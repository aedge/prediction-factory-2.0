<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"> Join League </h2>
    </div>
    <div class="panel-body">
        <form method="POST" action="leagues/join" class="inline-form">
            {!! csrf_field() !!}
        
            <div class="form-group">
                <label for="inLeagueCode">Code</label>
                <input type="text" id="inLeagueCode" name="code" class="form-control" placeholder="League Code" required autofocus>
        	</div>
        
            @if (count($errors) > 0)
                <!-- Form Error List -->
                <div class="alert alert-danger">
                    <strong> You couldn't be added to the league </strong>
            
                    <br><br>
            
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            <div>
                <button type="submit" class="btn btn-primary"> Join </button>
            </div>
        </form>
    </div>
</div>