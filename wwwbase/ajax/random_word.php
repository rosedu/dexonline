<?php
require_once("../../phplib/util.php");
require_once("../../phplib/db.php");

$responseText = "";

while(1) {
  // Because there are "gaps" in the IDs field I cannot know for sure if the
  // random number ID exist and must repeat untill I find it
  $max_words = db_getSingleValue("SELECT COUNT(*) as words FROM `Lexem`");
  
  $random_w = rand(0,$max_words);
  $Lexem = db_getArrayAssoc("SELECT * FROM `LexemDefinitionMap` WHERE `lexemId`='$random_w'");
  
  if($Lexem) {
    for($i=0; $i < count($Lexem); $i++) {
      $LexemDef = db_getArrayAssoc("SELECT * FROM `Definition` WHERE `id` = '".$Lexem[$i]['definitionId']."'");
      if(!$LexemDef)  //Unfortunately there are "dead" definitions in LexemDefinitionMap
        continue;
      $responseText .= "<br />".$LexemDef[0]['htmlRep']."<br />";
    }
    if($responseText=="")
      continue;
    else
      break;
  }
}
echo $responseText;

?>