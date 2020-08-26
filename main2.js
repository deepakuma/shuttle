var id, options;
var firebaseConfig = {
    apiKey: "AIzaSyCuN-7SqZLt7ffNVWbnOV7w-aDu_5a0maw",
    authDomain: "dtu-shuttle.firebaseapp.com",
    databaseURL: "https://dtu-shuttle.firebaseio.com",
    projectId: "dtu-shuttle",
    storageBucket: "dtu-shuttle.appspot.com",
    messagingSenderId: "162781514789",
    appId: "1:162781514789:web:62cb93edc75647f20903cc",
    measurementId: "G-GFPXX061Q2"
  };
  // Initialize Firebase
  var firebase=require("firebase/app");
  require("firebase/database");
  var sphereKnn=require("sphere-knn");
  firebase.initializeApp(firebaseConfig);
  var database=firebase.database();
function pointObject(lat,lng,num){
    this.latitude=lat,
    this.longitude=lng,
    this.pointnum=num
}
function calculateDistance(lat1, lng1, lat2, lng2) {
  if (typeof(Number.prototype.toRad) === "undefined") {
    Number.prototype.toRad = function() {
      return this * Math.PI / 180;
    }
  }
  var R = 6371; // km
  var dLat = (lat2-lat1).toRad();
  var dLon = (lng2-lng1).toRad();
  var lat1 = lat1.toRad();
  var lat2 = lat2.toRad();

  var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
    Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) *    Math.cos(lat2); 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  var distance = R * c;

  return distance;
}
var point1=new pointObject(28.541011, 77.157927,1);
var point2=new pointObject(28.540815, 77.158387,2);
var point3=new pointObject(28.540625, 77.158857,3);
var point4=new pointObject(28.540400, 77.159352,4);
var point5=new pointObject(28.540751, 77.159586,5);
var point6=new pointObject(28.541156, 77.159763,6);
lookup=sphereKnn([point1,point2,point3,point4,point5,point6]);
options ={
    enableHighAccuracy:true,
    timeout:1000,
    maximumage: 0
}
function liveLocation(evt){
	console.log(lookup(evt.coords.latitude,evt.coords.longitude,6)[0].pointnum)
    var lata=evt.coords.latitude;var lona=evt.coords.longitude;
    var currPointObj =lookup(evt.coords.latitude,evt.coords.longitude,6)[0];
    var currentPoint=currPointObj.pointnum;
    var distkm =calculateDistance(evt.coords.latitude,evt.coords.longitude, currPointObj.latitude, currPointObj.longitude)
    console.log(distkm*1000);
    if(distkm*1000<10) display1(currPointObj);//display(distkm);
    else display(currPointObj,distkm);
}
function usershuttledistance(userpoint,shuttlepoint){
  var userShuttleDist=(userpoint-shuttlepoint)*50;
  return userShuttleDist;
}
//read from database
function syncData(){
  var ShuttleLocObject=database.ref().child('shuttlelocation');
  ShuttleLocObject.on('value',snap => console.log(snap.val()));
}
function display1(currPointObj){
  var userpoint=currPointObj.pointnum;
  document.querySelector("h2").innerHTML="You have reached point "+userpoint;
  syncData();
}
function display(currPointObj,distkm){
  var userpoint=currPointObj.pointnum;
  document.querySelector("h2").innerHTML="Nearest Pickup Point "+userpoint;
  document.querySelector("h3").innerHTML="At a distance "+distkm*1000+" metre";  
  syncData();
}
function error(evt){
    console.log("error");
}
function buttonclick(){
  id=navigator.geolocation.watchPosition(liveLocation,error,options);
}
document.querySelector(".btn1").addEventListener("click",buttonclick);
document.querySelector(".btn2").addEventListener("click",function(){
	navigator.geolocation.clearWatch(id);
});