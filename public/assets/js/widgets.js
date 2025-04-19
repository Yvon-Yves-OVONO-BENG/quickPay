$(function(e){
  'use strict'

	//Spark1
    var spark1 = {
      chart: {
        type: 'area',
        height: 60,
		width: 160,
        sparkline: {
          enabled: true
        },
		dropShadow: {
			enabled: true,
			blur: 3,
			opacity: 0.2,
			show:false,
		}
		},
		stroke: {
			show: true,
			curve: 'smooth',
			lineCap: 'butt',
			colors: undefined,
			width: 2,
			dashArray: 0,
		},
      fill: {
        gradient: {
          enabled: false
        }
      },
      series: [{
		name: 'Total Revenue',
        data: [0, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46]
      }],
      yaxis: {
        min: 0
      },
      colors: ['#38cb89'],

    }
	var spark1 = new ApexCharts(document.querySelector("#spark1"), spark1);
    spark1.render();

	//Spark2
    var spark2 = {
      chart: {
        type: 'area',
        height: 60,
		width: 160,
        sparkline: {
          enabled: true
        },
		dropShadow: {
			enabled: true,
			blur: 3,
			opacity: 0.2,
		}
		},
		stroke: {
			show: true,
			curve: 'smooth',
			lineCap: 'butt',
			colors: undefined,
			width: 2,
			dashArray: 0,
		},
		fill: {
        gradient: {
          enabled: false
        }
      },
      series: [{
		name: 'Unique Visitors',
        data: [0, 45, 93, 53, 61, 27, 54, 43, 19, 46, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, ]
      }],
      yaxis: {
        min: 0
      },
      colors: ['#664dc9'],

    }
	var spark2 = new ApexCharts(document.querySelector("#spark2"), spark2);
    spark2.render();
	//Spark3
    var spark3 = {
      chart: {
        type: 'area',
        height: 60,
		width: 160,
        sparkline: {
          enabled: true
        },
		dropShadow: {
			enabled: true,
			blur: 3,
			opacity: 0.2,
		}
		},
		stroke: {
			show: true,
			curve: 'smooth',
			lineCap: 'butt',
			colors: undefined,
			width: 2,
			dashArray: 0,
		},
		fill: {
        gradient: {
          enabled: false
        }
      },
      series: [{
		name: 'Expenses',
        data: [0, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46,45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51]
      }],
      yaxis: {
        min: 0
      },
      colors: ['#2bcbba'],

    }
	var spark3 = new ApexCharts(document.querySelector("#spark3"), spark3);
    spark3.render();

	//Spark4
	var spark4 = {
		chart: {
		  type: 'area',
		  height: 60,
		  width: 160,
		  sparkline: {
			enabled: true
		  },
		  dropShadow: {
			  enabled: true,
			  blur: 3,
			  opacity: 0.2,
		  }
		  },
		  stroke: {
			  show: true,
			  curve: 'smooth',
			  lineCap: 'butt',
			  colors: undefined,
			  width: 2,
			  dashArray: 0,
		  },
		fill: {
		  gradient: {
			enabled: false
		  }
		},
		series: [{
		  name: 'Total Revenue',
		  data: [0, 45, 54, 38, 56, 24, 55, 31, 37, 39, 62, 51, 35, 41, 48, 27, 93, 53, 52, 27, 54, 43, 19, 46]
		}],
		yaxis: {
		  min: 0
		},
		colors: ['#ef4b4b'],
  
	  }
	  var spark4 = new ApexCharts(document.querySelector("#spark4"), spark4);
	  spark4.render();

	/* sparkline_bar11 */
	$(".sparkline_bar11").sparkline([2, 4, 3, 4, 5, 4,5,3,4,5,2,4,5,4,3,5,4,3,4,5,4,5,4,3,5,4,3,4,5], {
		type: 'bar',
		height: 50,
		width:250,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#fa057a'
	});
	/* sparkline_bar11 end */

	/* sparkline_bar12 */
	$(".sparkline_bar12").sparkline([3, 5, 4, 4, 5, 4,5,3,4,5,3,4,5,4,3,5,4,3,4,5,4,5,4,3,5,4,3,4,5], {
		type: 'bar',
		height: 50,
		width:250,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#f7346b'
	});
	/* sparkline_bar12 end */

	/* sparkline_bar13 */
	$(".sparkline_bar13").sparkline([3, 5, 4, 4, 5, 4,5,3,4,5,3,4,5,4,3,5,4,3,4,5,4,5,4,3,5,4,3,4,5], {
		type: 'bar',
		height: 50,
		width:250,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#2dce89'
	});
	/* sparkline_bar13 end */

	/* sparkline_bar14 */
	$(".sparkline_bar14").sparkline([3, 5, 4, 4, 5, 4,5,3,4,5,3,4,5,4,3,5,4,3,4,5,4,5,4,3,5,4,3,4,5], {
		type: 'bar',
		height: 50,
		width:250,
		barWidth: 5,
		barSpacing: 7,
		colorMap: {
			'9': '#a1a1a1'
		},
		barColor: '#45aaf2'
	});
	/* sparkline_bar14 end */

	/*----CryptoChart----*/
	/* Chartjs (#areaChart1) */
	var ctx = document.getElementById('CryptoChart').getContext('2d');

    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            type: 'line',
            datasets: [ {
				label: 'Market value',
				data: [30, 70, 30, 100, 50, 130, 100, 140],
				backgroundColor: 'transparent',
				borderColor: '#664dc9',
				pointBackgroundColor:'#fff',
				pointHoverBackgroundColor:'#664dc9',
				pointBorderColor :'#664dc9',
				pointHoverBorderColor :'#664dc9',
				pointBorderWidth :2,
				pointRadius :2,
				pointHoverRadius :2,
				borderWidth: 4
            }, ]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#6b6f80',
                bodyFontColor: '#6b6f80',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [ {
                    gridLines: {
                        color: 'transparent',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: 'transparent'
                    }
                } ],
                yAxes: [ {
                    display:false,
                    ticks: {
                        display: false,
                    }
                } ]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            }
        }
    });
	/*----End CrptoChart----*/

	/*----CryptoChart1----*/
	var ctx = document.getElementById('CryptoChart1').getContext('2d');

    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            type: 'line',
            datasets: [ {
				label: 'Market value',
				data: [30, 70, 30, 100, 50, 130, 100, 140],
				backgroundColor: 'transparent',
				borderColor: '#664dc9',
				pointBackgroundColor:'#fff',
				pointHoverBackgroundColor:'#664dc9',
				pointBorderColor :'#664dc9',
				pointHoverBorderColor :'#664dc9',
				pointBorderWidth :2,
				pointRadius :2,
				pointHoverRadius :2,
				borderWidth: 4
            }, ]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#6b6f80',
                bodyFontColor: '#6b6f80',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [ {
                    gridLines: {
                        color: 'transparent',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: 'transparent'
                    }
                } ],
                yAxes: [ {
                    display:false,
                    ticks: {
                        display: false,
                    }
                } ]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            }
        }
    });
	/*----End CrptoChart1----*/

	/*----CryptoChart2----*/
	var ctx = document.getElementById('CryptoChart2').getContext('2d');

    var myChart = new Chart( ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            type: 'line',
            datasets: [ {
				label: 'Market value',
				data: [30, 70, 30, 100, 50, 130, 100, 140],
				backgroundColor: 'transparent',
				borderColor: '#664dc9',
				pointBackgroundColor:'#fff',
				pointHoverBackgroundColor:'#664dc9',
				pointBorderColor :'#664dc9',
				pointHoverBorderColor :'#664dc9',
				pointBorderWidth :2,
				pointRadius :2,
				pointHoverRadius :2,
				borderWidth: 4
            }, ]
        },
        options: {
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            responsive: true,
            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#6b6f80',
                bodyFontColor: '#6b6f80',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            scales: {
                xAxes: [ {
                    gridLines: {
                        color: 'transparent',
                        zeroLineColor: 'transparent'
                    },
                    ticks: {
                        fontSize: 2,
                        fontColor: 'transparent'
                    }
                } ],
                yAxes: [ {
                    display:false,
                    ticks: {
                        display: false,
                    }
                } ]
            },
            title: {
                display: false,
            },
            elements: {
                line: {
                    borderWidth: 1
                },
                point: {
                    radius: 4,
                    hitRadius: 10,
                    hoverRadius: 4
                }
            }
        }
    });
	/*----End CrptoChart2----*/

  /*----CryptoChart3----*/
  var ctx = document.getElementById('CryptoChart3').getContext('2d');

  var myChart = new Chart( ctx, {
	  type: 'line',
	  data: {
		  labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
		  type: 'line',
		  datasets: [ {
			  label: 'Market value',
			  data: [30, 70, 30, 100, 50, 130, 100, 140],
			  backgroundColor: 'transparent',
			  borderColor: '#664dc9',
			  pointBackgroundColor:'#fff',
			  pointHoverBackgroundColor:'#664dc9',
			  pointBorderColor :'#664dc9',
			  pointHoverBorderColor :'#664dc9',
			  pointBorderWidth :2,
			  pointRadius :2,
			  pointHoverRadius :2,
			  borderWidth: 4
		  }, ]
	  },
	  options: {
		  maintainAspectRatio: false,
		  legend: {
			  display: false
		  },
		  responsive: true,
		  tooltips: {
			  mode: 'index',
			  titleFontSize: 12,
			  titleFontColor: '#6b6f80',
			  bodyFontColor: '#6b6f80',
			  backgroundColor: '#fff',
			  titleFontFamily: 'Montserrat',
			  bodyFontFamily: 'Montserrat',
			  cornerRadius: 3,
			  intersect: false,
		  },
		  scales: {
			  xAxes: [ {
				  gridLines: {
					  color: 'transparent',
					  zeroLineColor: 'transparent'
				  },
				  ticks: {
					  fontSize: 2,
					  fontColor: 'transparent'
				  }
			  } ],
			  yAxes: [ {
				  display:false,
				  ticks: {
					  display: false,
				  }
			  } ]
		  },
		  title: {
			  display: false,
		  },
		  elements: {
			  line: {
				  borderWidth: 1
			  },
			  point: {
				  radius: 4,
				  hitRadius: 10,
				  hoverRadius: 4
			  }
		  }
	  }
  });
	/*----End CrptoChart3----*/

	new Morris.Donut({
		element: 'morrisDonut1',
		data: [{
			label: 'Google',
			value: 42
		}, {
			label: 'Firefox',
			value: 22
		}, {
			label: 'IE',
			value: 36
		}],
		colors: ['#664dc9','#8976d5', '#ab9de1'],
		storke: ['#664dc9','#8976d5', '#ab9de1'],
		resize: true,
		backgroundColor: 'rgba(119, 119, 142, 0.2)',
		labelColor: '#8e9cad',
	});

	new Morris.Donut({
		element: 'morrisDonut2',
		data: [{
			label: 'Google',
			value: 35
		}, {
			label: 'Firefox',
			value: 40
		}, {
			label: 'IE',
			value: 25
		}],
		colors: ['#38cb89','#5dd59f', '#85e0b7'],
		storke: ['#38cb89','#5dd59f', '#85e0b7'],
		resize: true,
		backgroundColor: 'rgba(119, 119, 142, 0.2)',
		labelColor: '#8e9cad',
	});

	new Morris.Donut({
		element: 'morrisDonut3',
		data: [{
			label: 'Google',
			value: 38
		}, {
			label: 'Firefox',
			value: 42
		}, {
			label: 'IE',
			value: 20
		}],
		colors: ['#ffab00','#ffbb33', '#ffcc66'],
		storke: ['#ffab00','#ffbb33', '#ffcc66'],
		resize: true,
		backgroundColor: 'rgba(119, 119, 142, 0.2)',
		labelColor: '#8e9cad',
	});

	new Morris.Donut({
		element: 'morrisDonut4',
		data: [{
			label: 'Google',
			value: 34
		}, {
			label: 'Firefox',
			value: 34
		}, {
			label: 'IE',
			value: 32
		}],
		colors: ['#ef4b4b','#f37272', '#f7a1a1'],
		storke: ['#ef4b4b','#f37272', '#f7a1a1'],
		resize: true,
		backgroundColor: 'rgba(119, 119, 142, 0.2)',
		labelColor: '#8e9cad',
	});

 });