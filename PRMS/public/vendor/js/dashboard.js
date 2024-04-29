// $(function () {


//   // =====================================
//   // Profit
//   // =====================================
//   var chart = {
//     series: [
//       { name: "Earnings this month:", data: [355] },
//       { name: "Earnings this month:", data: [355] },
//       { name: "Earnings this month:", data: [355] },
//       { name: "Earnings this month:", data: [355] },
//     ],

//     chart: {
//       type: "bar",
//       height: 500,
//       offsetX: -15,
//       toolbar: { show: true },
//       foreColor: "#adb0bb",
//       fontFamily: 'inherit',
//       sparkline: { enabled: false },
//     },


//     colors: ["#5D87FF", "#49BEFF"],


//     plotOptions: {
//       bar: {
//         horizontal: false,
//         columnWidth: "50%",
//         borderRadius: [6],
//         borderRadiusApplication: 'end',
//         borderRadiusWhenStacked: 'all'
//       },
//     },
//     markers: { size: 10 },

//     dataLabels: {
//       enabled: false,
//     },


//     legend: {
//       show: false,
//     },


//     grid: {
//       borderColor: "rgba(0,0,0,0.4)",
//       strokeDashArray: 3,
//       xaxis: {
//         lines: {
//           show: false,
//         },
//       },
//     },

//     xaxis: {
//       type: "category",
//       categories: ["succ", "succ", "succ", "succ", "succ", "succ", "succ", "23/08"],
//       labels: {
//         style: { cssClass: "grey--text lighten-2--text fill-color" },
//       },
//     },


//     yaxis: {
//       show: true,
//       min: 0,
//       max: 700,
//       tickAmount: 4,
//       labels: {
//         style: {
//           cssClass: "grey--text lighten-2--text fill-color",
//         },
//       },
//     },
//     stroke: {
//       show: true,
//       width: 3,
//       lineCap: "butt",
//       colors: ["transparent"],
//     },


//     tooltip: { theme: "light" },

//     responsive: [
//       {
//         breakpoint: 600,
//         options: {
//           plotOptions: {
//             bar: {
//               borderRadius: 3,
//             }
//           },
//         }
//       }
//     ]


//   };

//   var chart = new ApexCharts(document.querySelector("#chart"), chart);
//   chart.render();


//   // =====================================
//   // Breakup
//   // =====================================
//   var breakup = {
//     color: "#adb5bd",
//     series: [38, 40, 25],
//     // labels: caseTypes,
//     chart: {
//       width: 300,
//       type: "donut",
//       fontFamily: "Plus Jakarta Sans', sans-serif",
//       foreColor: "#adb0bb",
//     },
//     plotOptions: {
//       pie: {
//         startAngle: 0,
//         endAngle: 360,
//         donut: {
//           size: '50%',
//         },
//       },
//     },
//     stroke: {
//       show: false,
//     },

//     dataLabels: {
//       enabled: false,
//     },

//     legend: {
//       show: false,
//     },
//     colors: colors,

//     responsive: [
//       {
//         breakpoint: 991,
//         options: {
//           chart: {
//             width: 150,
//           },
//         },
//       },
//     ],
//     tooltip: {
//       theme: "dark",
//       fillSeriesColor: false,
//     },
//   };

//   var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
//   chart.render();



//   // =====================================
//   // Earning
//   // =====================================
//   var earning = {
//     chart: {
//       id: "sparkline3",
//       type: "area",
//       height: 0,
//       sparkline: {
//         enabled: true,
//       },
//       group: "sparklines",
//       fontFamily: "Plus Jakarta Sans', sans-serif",
//       foreColor: "#adb0bb",
//     },
//     series: [
//       {
//         name: "Earnings",
//         color: "#49BEFF",
//         data: [25, 66, 20, 40, 12, 58, 20],
//       },
//     ],
//     stroke: {
//       curve: "smooth",
//       width: 2,
//     },
//     fill: {
//       colors: ["#f3feff"],
//       type: "solid",
//       opacity: 0.05,
//     },

//     markers: {
//       size: 0,
//     },
//     tooltip: {
//       theme: "dark",
//       fixed: {
//         enabled: true,
//         position: "right",
//       },
//       x: {
//         show: false,
//       },
//     },
//   };
//   new ApexCharts(document.querySelector("#earning"), earning).render();
// })