/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./resources/js/charts.js ***!
  \********************************/
window.loadMaleFemaleChart = function (selector, route) {
  $.ajax({
    type: 'GET',
    url: route
  }).done(function (data) {
    var ctx = $(selector);
    new Chart(ctx, {
      type: 'pie',
      data: {
        datasets: [{
          backgroundColor: ['#FF6384', '#36A2EB'],
          hoverBackgroundColor: ['#FF6384', '#36A2EB'],
          data: Object.values(data)
        }],
        labels: Object.keys(data)
      }
    });
  }).fail(function () {
    console.log("Error retrieving chart data");
  });
};

window.loadRevenueChart = function (selector, route) {
  $.ajax({
    type: 'GET',
    url: route
  }).done(function (data) {
    var ctx = $(selector);
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.months,
        datasets: [{
          data: data.incomes,
          label: "Africa",
          borderColor: "#3e95cd",
          fill: false
        }]
      }
    });
  }).fail(function () {
    console.log("Error retrieving chart data");
  });
};
/******/ })()
;