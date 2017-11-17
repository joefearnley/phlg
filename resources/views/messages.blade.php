<!doctype html>
<html lang="en">
  <head>
    <title>Lowphashion</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-light bg-light">
      <a class="navbar-brand" href="/">Lowphashion</a>
    </nav>
    <div class="container">
      <div class="row mt-5">
        <select id="select-application" class="custom-select">
          <option value="/" {{ $application ? "selected" : "" }}>All Applications</option>
          @foreach ($applications as $app)
            <option value="/messages/application/{{ $app->id }}" {{ $application->id === $app->id ? "selected" : "" }}>{{ $app->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="row mt-5">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Date</th>
              <th scope="col">Level</th>
              <th scope="col">Application</th>
              <th scope="col">Message</th>
            </tr>
          </thead>
          <tbody>
          @if ($messages->isEmpty())
            <tr>
              <td>No messages found</td>
            </tr>
          @else
            @foreach ($messages as $message)
              <tr>
                <td>{{ $message->created_at->format('m/d/Y h:i:s a') }}</td>
                <td>{{ $message->level }}</td>
                <td>{{ $message->application->name }}</td>
                <td>{{ $message->body }}</td>
              </tr>
            @endforeach
          @endif
          </tbody>
        </table>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <script>
      $(function() {
        $('#select-application').change(function() {
          window.location = $(this).val();
        });
      });
    </script>
  </body>
</html>