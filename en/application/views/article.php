<?php
$id = $_GET['id'];
$this->mongodb->where(['_id' => mongo_id($id)]);
$qry = $this->mongodb->get('Articles');
foreach($qry as $res){
$title = $res['articleheading'];
$url = $res['ArticleUrl'];
$description = $res['ArticleDescription'];
}
?>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script type="text/javascript">
  if(history.replaceState) history.replaceState({}, "", "<?=$url;?>");
</script>
<style>
.desc img{width:50%;margin:5px;}
</style>
<body>
<div class="container">
  <div class='col-md-12'><h2><?=$title;?></h2><hr/></div>
  <div class='col-md-12 desc'><?=$description;?></div>
</div>
</body>