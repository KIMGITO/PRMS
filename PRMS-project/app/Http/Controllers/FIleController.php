<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Court;
use App\Models\Judge;
use App\Models\Purpose;
use App\Models\Casetype;
use App\Models\Department;
use App\Models\Transaction;
use illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class FIleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::paginate(10);
        foreach($files as $file){
        $data = Transaction::where('file_id',$file->id)->orderBy('created_at','desc')->first();
            if(!empty($data)){
                if($data['dateBack'] != null){
                    $file['status'] = 'available';
                }else{
                    $file['status']= 'on Loan';
                }
            }else{
                $file['status'] = 'available';
            }
        }

        $message = "";
        if($files->count() == 0){
            $message = "No files found";
        }
        return view('files.list-files',[
            'files'=>$files,
            'query'=>'',
            'message'=>$message
        ]);


    }

    /**
     * Show the form for creating a new resource.
     */
    
     public function search(Request $request)
     {
        $query = $request->input('query');
        if(empty($query)){
            return redirect()->route('list.files');
        }
        if(Str::startsWith($query,'filter=')){
            $query = Str::replace('filter=','',$query);
            $sorts = explode(':',$query);
            $direction = strlen($sorts[0])>0 ? $sorts[0] : null;
            $from = strlen($sorts[1])>0 ? $sorts[1] : null;
            $to = strlen($sorts[2])>0 ? $sorts[2] : null;
            
            // switch to create query based on available query
            switch (true) {
                // Case 1: All variables are available
                case(!empty($direction) && !empty($from) && !empty($to)):
                    $result = File::whereBetween('filing_date', [$from, $to])->orderBy('filing_date',$direction);
                    break;
                // Case 2: Only $direction is available
                case (!empty($direction) && empty($from) && empty($to)):
                    $result = File::orderBy('filing_date',$direction);
                    break;
            
                // Case 3: Only $from is available
                case (empty($direction) && !empty($from) && empty($to)):
                    $result = File::whereDate('filing_date', '>=',$from)->orderBy('filing_date','asc');
                    break;
            
                // Case 4: Only $to is available
                case (empty($direction) && empty($from) && !empty($to)):
                    $result = File::whereDate('filing_date', '<=',$to)->orderBy('filing_date','desc');
                    break;
                // Case 5: Only $direction and $from are available
                case (!empty($direction) && !empty($from) && empty($to)):
                    $result = File::whereDate('filing_date', '>=',$from)->orderBy('filing_date',$direction);
                    break;
                    
                // Case 6: Only $direction and $to are available
                case (!empty($direction) && empty($from) && !empty($to)):
                    $result = File::whereDate('filing_date', '<=',$to)->orderBy('filing_date',$direction);
                    break;
            
                // Case 7: Only $from and $to are available
                case (empty($direction) && !empty($from) && !empty($to)):
                    $result = File::whereBetween('filing_date', [$from, $to])->orderBy('filing_date','asc');
                    break;
                // Case 8: None is available
                case (empty($direction) && empty($from) && empty($to)):
                    return redirect()->route('list.files');
            }
            $sortResults = $result->get();
            
            $message = "";
            if($sortResults->count() == 0){
                $message="No results found for that filter.";
            } 
            return view('files.list-files',[
                'files'=>$sortResults,
                'query'=>null,
                'message'=> $message
            ]);
        }

        $results = File::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('case_number', 'like', "%$query%")
                        ->orWhere('case_description', 'like', "%$query%")
                        ->orWhere('plaintiffs', 'like', "%$query%")
                        ->orWhere('defendants', 'like', "%$query%");
            })
            ->orWhereHas('court', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%");
            })
            ->orWhereHas('judge', function ($queryBuilder) use ($query) {
                $queryBuilder->where('name', 'like', "%$query%");
            })
            ->orWhereHas('casetype', function ($queryBuilder) use ($query) {
                $queryBuilder->where('case_type', 'like', "%$query%");
            })->get();

            if(!empty($results)){
                foreach($results as $file){
                    $data = Transaction::where('file_id',$file->id)->orderBy('created_at','desc')->first();
                        if(!empty($data)){
                            if($data['dateBack'] != null){
                                $file['status'] = 'available';
                            }else{
                                $file['status']= 'on Loan';
                            }
                        }else{
                            $file['status'] = 'available';
                        }
                }
            
            }

            

           
            $message = "";
            if($results->count() == 0){
                $message="No results for ".$query;
            }
            return view('files.list-files',[
                'files'=>$results,
                'query'=>$query,
                'message'=> $message
            ]);


     }
    /**
     * search file
     */
    public function create()
    {
        $types = Casetype::all();
        $judges = Judge::all();
        $courts = Court::all();
        return view('files.add-file',[
            'types' => $types,
            'courts' => $courts,
            'judges' => $judges
        ]);
    }

    /**
     * SHow the file to loan
     * 
     */
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // check for constraints
        $customAttributes = [
            'caseNumber' => 'case number',
            'caseType'=>'case type',
            'filingDate'=>'filing date',
            'rullingDate'=>'Rulling Date',
            'plaintiffs'=>'plaintiff(s)',
            'defendants'=>'defendant(s)',
            'judge'=>'presiding judge',
            'court'=>'court',
            'caseDescription'=>'case description'
        ];
        Validator::extend('select', function ($attribute, $value, $parameters, $validator) {
            return $value != '0';
        });

        $validator = Validator::make($request->all(),[
            'caseNumber'=>'required|string|unique:files,case_number',
            'caseType'=>'required|integer|select',
            'filingDate'=>'required|date|before:+0 day',
            'rullingDate'=>'nullable|date|before:+0 day',
            'plaintiffs'=>'required|string|min:5',
            'defendants'=>'required:string|min:5',
            'judge'=>'required|integer|select',
            'court'=>'required|integer|select',
            'caseDescription'=>'nullable|max:300|string'
        ],[ //cusom error messages
            'select'=>'Please select one option from :attribute selections',
            'plaintiff.required'=>'A plaintiff or Plaintiffs are required.',
            'defendant.required'=>'A defendant or defendants are required.',
            'before'=>'The :attribute must be today or the past.'
        ]);
        $validator->setAttributeNames($customAttributes);


        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            // add the initials as devined
            $caseNumber = $request->input('caseNumber');
            if(preg_match('/\d/',$caseNumber,$match)){
                $position = strpos($caseNumber,$match[0]);
                $caseNumber = substr($caseNumber,$position);
            }

            $file = new File();

            $file->case_number = $caseNumber;
            $file->casetype_id= $request->input("caseType");
            $file->filing_date= $request->input("filingDate");
            $file->ruling_date= $request->input("rullingDate");
            $file->plaintiffs= $request->input("plaintiffs");
            $file->defendants= $request->input("defendants");
            $file->judge_id= $request->input("judge");
            $file->court_id= $request->input("court");
            $file->case_description= $request->input("caseDescription");

            if($file->save()){
                return redirect()->back()->with('success','File added successiffuly');
            }else{
                return redirect()->back()->with('error','Filed to add the file')->withInput();
            }

    }

   
    
    /**
     * Display the specified resource.
     */
    public function info($id)
    {
       try {
        $id = decrypt($id);
        $info = File::where(['id' => $id])->firstOrFail();

        $count = Transaction::select('id')->where(['file_id'=>$id])->whereNotNull('dateBack')->count();
        $status = Transaction::where('file_id',$id)->orderBy('created_at','desc')->first();
        if(!empty($status)){
            if($status['dateBack'] != null){
                $info['status'] = 'available';
            }else{
                $info['status']= 'on Loan';
            }
        }else{
            $info['status'] = 'available';
        }
        
        $baseUrl = URL::to('/');
        $previousUrl = URL::previous();
        $backRoute = str_replace($baseUrl, '', parse_url($previousUrl, PHP_URL_PATH));
        $backRoute = ltrim($backRoute, '/');
        $backRoute = str_replace('/', '-', $backRoute);
        $info['url'] = $backRoute;
        $info['transaction_count'] = $count;

        return view('files.file-info',['info'=>$info]);
       } catch (\Throwable $th) {
        dd($th->getMessage());
        abort(404);
        return;
       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        //
    }
}
