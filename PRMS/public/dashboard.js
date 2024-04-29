
// var chart = {
//     series: [{
//         name: 'Records Distribution',
//         data: popCount,
//     }],
//     chart: {
//         type: 'bar',
//         height: 250
//     },
//     plotOptions: {
//         bar: {
//             horizontal: true,
//             columnWidth: "90%",
//             borderRadiusApplication: 'end',
//             borderRadiusWhenStacked: 'all'
//           },
//     },
//     dmarkers: { size: 10 },

//     dataLabels: {
//       enabled: false,
//     },
//     legend: {
//         show: false,
//       },
  
  
//       grid: {
//         borderColor: "rgba(0,0,0,0.1)",
//         strokeDashArray: 3,
//         xaxis: {
//           lines: {
//             show: false,
//           },
//         },
//       },

    
//     xaxis: {
//         categories: popInitials,
//         title: {
//             text: '(records)'
//         }
//     },
//     yaxis: {
//         title: {
//             text: '(case types)'
//         }
//     },
//     fill: {
//         opacity: 1
//     },
//     tooltip: {
//         y: {
//             formatter: function (val) {
//                 return  val + " records"
//             }
//         },
//         x: {
//             formatter: function (val) {
//                 return getFullMonthName(val);
//             }
//         }
//     },
//     colors: popColors
// };
// var chart = new ApexCharts(document.querySelector("#records"), chart);
// chart.render();


popInitials;
popNames;
function getFullMonthName(shortMonth) {
    var monthMap = Object.fromEntries(popInitials.map((key, i) => [key, popNames[i]]));
    return monthMap[shortMonth];
}


/**
 * Pie Charts
 */
var pieChartOptions = {
  series: popCount,
  chart: {
    type: 'donut',
    height: 280,
    width: 300, // Set an appropriate width for the donut chart
  },
  labels: popNames,
  dataLabels: {
    enabled: false,
  },
  legend: {
    show: false,
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return `${val} / ${totals} Records` ;
      }
    },
  },
  plotOptions: {
    pie: {
      donut: {
        size: '45%' 
      }
    }
  },
  colors: popColors
};

var pieChart = new ApexCharts(document.querySelector("#records"), pieChartOptions);
pieChart.render();


// =====================================
  // Earning
  // =====================================
  var newAreaChartOptions = {
    series: [
      {
          color : '#0bbd0b',
          name: 'Loaning Rate ',
          data: transactions['issuedCounts']
      },{
          color: '#ad31a1',
          name : 'Return Rate',
          data : transactions['returnCounts']
      }
    ],
    chart: {
    height: 300,
    type: 'area',
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth',
    width: 1
  },
  fill: {
    color: ["#f3feff"],
    type: "solid",
    opacity: 0.4,
},
tooltip: {
    theme: "dark",
    fixed: {
    enabled: true,
    position: "center",
    }
    },
  xaxis: {
    type: 'datetime',
    categories : transactions['dates']
    
  },
yaxis: {
    labels: {
        formatter: function (value) {
            return Math.floor(value);
        }
    }
}
  
  };


new ApexCharts(document.querySelector("#records-population"), newAreaChartOptions).render();