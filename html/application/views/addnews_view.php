<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>News Crossover</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/style.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">



    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,800,300,300italic' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="container">
      <div class="row row-title">
        <span class="page-title pull-left">News Crossover</span>
        
      </div>

      <div class="row row-formnews">
        <?php echo form_open_multipart('dashboard/do_upload', array('class' => 'form-horizontal', 'role' => 'form')); ?>
        <fieldset>

        <!-- Form Name -->
        <legend>Add new article</legend>

        <div class="form-group">
          <div class="col-lg-3">
            <label for="news_title">News Title</label>
          </div>
          <div class="col-lg-6">
          <input type="text" class="form-control" id="news_title" name="news_title" required="true">
          </div>    
        </div>

        <div class="form-group">
          <div class="col-lg-3">
            <label for="news_photo">News Photo</label>
          </div>
          <div class="col-lg-6">
          <input type="file" id="news_photo" name="news_photo" required="true">
          </div>    
        </div>

        <div class="form-group">
          <div class="col-lg-3">
            <label for="news_text">News Text</label>
          </div>
          <div class="col-lg-6">
          <textarea class="form-control" rows="8" name="news_text" id="news_text" required="true"></textarea>
          </div>    
        </div>

        <p>
          <?php 
          if (isset($error)) {
            echo $error;
          }
          ?>
          <?php echo validation_errors(); ?>

        </p>

        <div class="pull-right">
          <button type="submit" class="btn btn-primary">Save Article</button>
          <button type="button" class="btn btn-danger">Cancel</button>
        </div>

        </fieldset>
        </form>
      </div>

    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  
    <script type="text/javascript">
      
      $(document).ready(function(){
          $('#myNews').DataTable();
      });

    </script>

  </body>
</html> 