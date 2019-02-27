<?php
echo "TREE BASED<br />";
  // $html = "";
  // $url = "http://news.cnet.com/8300-1009_3-83.xml";
  // $xml = simplexml_load_file($url);
  // for ($i = 0; $i < 10; $i++) {
  //     $title = $xml->channel->item[$i]->title;
  //     $link = $xml->channel->item[$i]->link;
  //     $description = $xml->channel->item[$i]->description;
  //     $pubDate = $xml->channel->item[$i]->pubDate;
  //     $html .= "<a href='$link'><h3>$title</h3></a>";
  //     $html .= "$description";
  //     $html .= "<br />$pubDate<hr />";
  // }
  // echo $html;

$xml=simplexml_load_file("books.xml") or die("Error: Cannot create object");
echo $xml->book[0]->title . "<br>";
echo $xml->book[1]->title . "<br />";
echo $xml->book[0]->getName();

// $xml = simplexml_load_file("books.xml");
//   echo $xml->getName() . "<br/><br/>";
//   foreach ($xml->children() as $child=>$data) {
//       echo $child.":";
//       echo $data->title."<br />";
//       echo "";
//   }
