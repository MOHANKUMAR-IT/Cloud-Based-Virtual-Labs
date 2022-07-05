<?php

  $url = "http://".$_SERVER['SERVER_NAME'] .":5000/v2/_catalog";

  // Initialize a CURL session.
  $ch = curl_init();
   
  // Return Page contents.
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   
  //grab URL and pass it to the variable.
  curl_setopt($ch, CURLOPT_URL, $url);
   
  $result = JSON_encode(curl_exec($ch));
?>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
  </head>
<body  ng-app="myapp" ng-controller = "myctrl">
  <table>
  <tr>
  <th>Repositroies</th>
  <th>Run</th>
  <th>Delete</th>

  </tr>
  <tr ng-repeat="i in list">
  <td>{{i}}</td>
  <td><button ng-click="run(i)">Run</button></td>
  <td><button ng-click = "delete(i)">Delete</button></td>
  </tr>
  </table>
</body>
<script>
  var app = angular.module("myapp",[]);
  app.controller("myctrl",function($scope){
    console.log(JSON.parse(<?php echo $result ?>)["repositories"]);
    $scope.list = JSON.parse(<?php echo $result ?>)["repositories"];
    $scope.run = (img)=>{
        console.log("Running "+img);
      };
    $scope.delete = (img)=>{
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          alert(this.responseText);
        }
      };
      xmlhttp.open("POST","\\ITOM\\AJAX\\deleteImage.php?img="+img,true);
      xmlhttp.send();
    };
    $scope.run = (img)=>{
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var port = this.responseText;
          window.location = "runningShell.html?port="+port+"&name="+img;
        }
      };
      xmlhttp.open("POST","\\ITOM\\AJAX\\runImage.php?img="+img,true);
      xmlhttp.send();
    };
  });

  </script>





