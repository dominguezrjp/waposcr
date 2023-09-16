<?php
error_reporting(1);

if(isset($_GET['Fdata'])){
$data = unserialize(urldecode($_GET['Fdata']));
$manifest = [
"short_name"=> $data['title'],
"name"=> $data['title'],
"background_color" => "#{$data['background_color']}",
"theme_color" => "#{$data['theme_color']}",
"display"=> "standalone",
"icons" => [
  [
      "src"=>  $data['img_144'],
      "type"=> "image/png",
      "sizes"=> "144x144",
    ],
    [
      "src"=>  $data['img_192'],
      "type"=> "image/png",
      "sizes"=> "192x192",
    ],
    [
      "src"=>  $data['img_512'],
      "type"=> "image/png",
      "sizes"=> "512x512",
    ],
    
  ],
  
  "start_url"=> '/'.$data['username'].'/',
  "scope"=> '/'.$data['username'],
];

header('Content-Type: application/json');
echo json_encode($manifest);

}