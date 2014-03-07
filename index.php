<?php
require_once 'get.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>TA Exercises</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Le styles -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet"> -->
    <!-- Le fav and touch icons -->
  </head>

  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="page-header">TA Exercises <small>Let your assistant know how difficult an exercise was</small></h1>
          <br>
          <h2>Rate an Exercise Set</h2>
          <?php
          function diffChoose($name, $g, $o, $r){
              return '<div class="btn-group pull-right" data-toggle=buttons>
              <label class="btn btn-success"><input type=radio name="'.$name.'" value=green><span class="badge">'.$g.'</span></label>
              <label class="btn btn-warning"><input type=radio name="'.$name.'" value=orange><span class="badge">'.$o.'</span></label>
              <label class="btn btn-danger"><input type=radio name="'.$name.'" value=red><span class="badge">'.$r.'</span></label>
            </div>
            <div class="clearfix"></div>';
          }
          ?>
          <?php foreach($entries as $exercise): ?>
            <div class="panel panel-default">
              <form action="save.php?id=<?=$exercise->id?>" method="post">
              <div class="panel-heading"><?=$exercise->subject?>: Set #<?=$exercise->ex_set?> <small>TA: <?=$exercise->ta?></small></div>
              <div class="panel-body">
                <?php
                $partials = json_decode($exercise->exercises);
                $votes = json_decode($exercise->votes);
                foreach($partials as $no => $parts):
                ?>
                <ul class="list-group col-md-3">
                <?php if(!empty($parts)):?>
                  <?php foreach($parts as $part): ?>
                  <li class="list-group-item"><?=$no?>. <?=$part?>)<?=diffChoose($no.'-'.$part, @$votes->$no->$part->green, @$votes->$no->$part->orange, @$votes->$no->$part->red)?></li>
                  <?php endforeach; ?>
                <?php else:?>
                <li class="list-group-item"><?=$no?>.<?=diffChoose($no, @$votes->$no->green, @$votes->$no->orange, @$votes->$no->red)?></li>
                <?php endif;?>
                </ul>
                <?php endforeach; ?>
                <div class="clearfix"></div>
                <button type="submit" class="btn btn-primary col-md-12">Save</button>
              </div>
              </form>
            </div>
            <br>
            <hr>
          <?php endforeach; ?>
          <h2>Add a New Exercise Set</h2>
          <form class="form-horizontal" role="form" action="add.php" method="post">
            <div class="form-group">
              <label for="subject" class="col-sm-2 control-label">subject</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="subject" list="subjects" autocomplete=off placeholder="subject">
                <datalist id="subjects">
                  <?php foreach($subjectList as $subject): ?>
                  <option value="<?=$subject?>"></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>
            <div class="form-group">
              <label for="ta" class="col-sm-2 control-label">ta</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="ta" list="tas" autocomplete=off placeholder="ta">
                <datalist id="tas">
                  <?php foreach($taList as $ta): ?>
                  <option value="<?=$ta?>"></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>
            <div class="form-group">
              <label for="ex_set" class="col-sm-2 control-label">ex_set</label>
              <div class="col-sm-10">
                <input type="number" min=1 max=15 class="form-control" name="ex_set" placeholder="ex_set">
              </div>
            </div>
            <div class="form-group">
              <label for="exercises" class="col-sm-2 control-label">exercises</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="exercises" placeholder="1:a-f,2,3:a,4:a-b">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Add</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div><!--/.container-->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  </body>
</html>

