<?php
require_once 'get.php';
if(isset($_GET['admin'])){
  define('ADMIN', true);
}else{
  define('ADMIN', false);
}
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
          <ul class="nav nav-pills" id="ta-filter">
          <li class="disabled"><a href="#">Choose your assistant</a></li>
          <?php foreach($taList as $hash => $ta): ?>
          <li><a href="#" data-filter="<?=$hash?>"><?=$ta?></a></li>
          <?php endforeach; ?>
          </ul>
          <h2>Rate an Exercise Set</h2>
          <?php
          function diffChoose($name, $g, $o, $r){
            $g = $g+0;
            $o = $o+0;
            $r = $r+0;
              return '<div class="btn-group pull-right" data-toggle=buttons>
              <label class="btn btn-success"><input type=radio name="'.$name.'" value=green><span class="badge">'.$g.'</span></label>
              <label class="btn btn-warning"><input type=radio name="'.$name.'" value=orange><span class="badge">'.$o.'</span></label>
              <label class="btn btn-danger"><input type=radio name="'.$name.'" value=red><span class="badge">'.$r.'</span></label>
            </div>
            <div class="clearfix"></div>';
          }
          ?>
          <section id="exercises">
          <?php foreach($entries as $exercise): ?>
              <div class="panel panel-default" data-ta-hash="<?=$exercise->taHash?>">
                <form action="save.php?id=<?=$exercise->id?>" method="post">
                <h3 class="panel-heading"><?=$exercise->subject?>: Set #<?=$exercise->ex_set?> <span class="pull-right">TA: <?=$exercise->ta?></span class="pull-right"></h3>
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
                  <button type="submit" class="btn btn-primary col-xs-12 col-md-12">Save</button>
                  <?php if(ADMIN): ?>
                    <hr>
                    <a href="delete.php?id=<?=$exercise->id?>&what=votes" class="btn btn-warning col-xs-12 col-md-5">Remove votes</a>
                    <a href="delete.php?id=<?=$exercise->id?>&what=exercise" class="btn btn-danger col-xs-12 col-md-5 col-md-push-2">Delete exercise</a>
                  <?php endif; ?>
                </div>
                </form>
              </div>
            <?php endforeach; ?>
          </section>
          <div class="clearfix"></div>
          <?php if(ADMIN): ?>
          <h2>Add a New Exercise Set</h2>
          <form class="form-horizontal" role="form" action="add.php" method="post">
            <div class="form-group">
              <label for="subject" class="col-sm-2 control-label">Subject</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="subject" list="subjects" autocomplete=off>
                <datalist id="subjects">
                  <?php foreach($subjectList as $subject): ?>
                  <option value="<?=$subject?>"></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>
            <div class="form-group">
              <label for="ta" class="col-sm-2 control-label">Assistant</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="ta" list="tas" autocomplete=off>
                <datalist id="tas">
                  <?php foreach($taList as $ta): ?>
                  <option value="<?=$ta?>"></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>
            <div class="form-group">
              <label for="ex_set" class="col-sm-2 control-label">Exercise set</label>
              <div class="col-sm-10">
                <input type="number" min=1 max=15 class="form-control" name="ex_set">
              </div>
            </div>
            <div class="form-group">
              <label for="exercises" class="col-sm-2 control-label">Exercises</label>
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
          <h2>Duplicate an Exercise for Other Assistants</h2>
          <form class="form-horizontal" role="form" action="duplicate.php" method="post">
            <div class="form-group">
              <label for="subject" class="col-sm-2 control-label">Subject</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="subject" list="subjects" autocomplete=off>
                <datalist id="subjects">
                  <?php foreach($subjectList as $subject): ?>
                  <option value="<?=$subject?>"></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>
            <div class="form-group">
              <label for="source-ta" class="col-sm-2 control-label">Source assistant</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="source-ta" list="source-tas" autocomplete=off>
                <datalist id="source-tas">
                  <?php foreach($taList as $ta): ?>
                  <option value="<?=$ta?>"></option>
                  <?php endforeach; ?>
                </datalist>
              </div>
            </div>
            <div class="form-group">
              <label for="ex_set" class="col-sm-2 control-label">Exercise set</label>
              <div class="col-sm-10">
                <input type="number" min=1 max=15 class="form-control" name="ex_set">
              </div>
            </div>
            <div class="form-group">
              <label for="destination-ta" class="col-sm-2 control-label">Destination assistants</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="destination-ta" list="destination-tas" placeholder="Name1, Name2, Name3">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Duplicate</button>
              </div>
            </div>
          </form>
        <?php endif; ?>
        </div>
      </div>
      <footer>
        <div class="row">
          <hr>
          <div class="col-md-4"><p>Built with <a href="http://getbootstrap.com/">Bootstrap</a>, <a href="http://php.net/">PHP</a> &amp; <a href="http://www.sqlite.org/">SQLite</a></p></div>
          <div class="col-md-4 text-center">Source code available at <a href="https://github.com/limenet/ta-exercises">GitHub</a></div>
          <div class="col-md-4 text-right"><a href="http://linusmetzler.me">Linus Metzler</a></div>
        </div>
      </footer>
    </div><!--/.container-->
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script>
    jQuery(document).ready(function($) {
      // filter items on button click
      $('#ta-filter').on( 'click', 'a[data-filter]', function( event ) {
        $('#ta-filter li').removeClass('active');
        $(this).parent().addClass('active');
        var filterValue = $(this).data('filter');
        console.log(filterValue);
        $('[data-ta-hash]').hide();
        $('[data-ta-hash]').each(function(index, el) {
          var $this = $(this);
          console.log($this.data('ta-hash'));
          if($this.data('ta-hash') == filterValue)
            $this.show();
        });
      });
    });

    </script
  </body>
</html>

