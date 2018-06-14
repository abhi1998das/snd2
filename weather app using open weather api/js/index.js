$(document).ready(function(){

var lat;
  var long;
    $.getJSON("http://ip-api.com/json",function(data2){
      lat=data2.lat;
      long= data2.lon;
       var api = 'http://api.openweathermap.org/data/2.5/weather?lat='+lat+'&lon='+long+'&appid=your appid'; 
    
$.getJSON(api, function(data){
       var fTemp;
  var cTemp;
  var kTemp;
      var tempSwap=true;
    //JSON call for Open Weather API
   var weatherType= data.weather[0].description;
        kTemp = data.main.temp;
       var windSpeed= data.wind.speed;
    var city = data.name;
    //Temperture in Kelvin
    fTemp = (kTemp*(9/5)-459.67).toFixed(1);
    //Temp in F
    //City name
    cTemp = (kTemp-273).toFixed(1);
      console.log(city);
     $("#city").html(city);
      $("#weatherType").html(weatherType);
      $("#fTemp").html(fTemp + " &#8457;");
      $("#fTemp").click(function(){
        if(tempSwap===false){
          $("#fTemp").html(fTemp + " &#8457;"); 
          tempSwap=true;
        }
        else{
          $("#fTemp").html(cTemp + " &#8451;");
          tempSwap=false;
        }   
      });
windSpeed = (2.237*(windSpeed)).toFixed(1);
       $("#windSpeed").html(windSpeed + " mph");
    if(fTemp>80){
     $('body').css('background-image','url(https://images.unsplash.com/photo-1414269665217-a57681e266b3?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&w=1080&fit=max&s=6fd9f051bea811268593340698b6a822)');
    }
     else if(fTemp>70){
         $('body').css('background-image','url(https://images.unsplash.com/photo-1428592953211-077101b2021b?crop=entropy&fit=crop&fm=jpg&h=1000&ixjsv=2.1.0&ixlib=rb-0.3.5&q=80&w=1925)');
     }
       else if(fTemp>60){
         $('body').css('background-image','url(https://images.unsplash.com/photo-1428592953211-077101b2021b?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&w=1080&fit=max&s=9dee70ba78c49619bc7f5c8a91778f2b)');
     }
      else if(fTemp>50){
        $('body').css('background-image','url(https://images.unsplash.com/photo-1422020297037-97bd356cc312?crop=entropy&fit=crop&fm=jpg&h=1250&ixjsv=2.1.0&ixlib=rb-0.3.5&q=80&w=2400)');
      } 
  });
    });
 //API URL with geolocation
   

});