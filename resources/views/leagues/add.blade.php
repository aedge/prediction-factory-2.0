<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title"> Create League </h2>
    </div>
    <div class="panel-body">
        <form method="POST" action="leagues/new">
            {!! csrf_field() !!}
        
            <div class="form-group">
                <label for="inLeagueName">Name</label>
                <input type="text" id="inLeagueName" name="name" class="form-control" placeholder="Name" required autofocus>
        	</div>
        
            <div class="form-group">
                <label for="inLeagueDesc">Description</label>
                <input type="text" id="inLeagueDesc" name="description" class="form-control" placeholder="Description">
        	</div>
        	
        	<div class="form-group">
                <label for="selCompetition">Competition</label>
                <select id="selCompetition" name="competition_id" class="form-control">
                    @if (count($competitions) > 0)
                        @foreach($competitions as $competition)
                            <option value="{{ $competition->id }}">{{ $competition->name }}</option>
                        @endforeach
                    @endif
                </select>
        	</div>
            
            @if (count($errors) > 0)
                <!-- Form Error List -->
                <div class="alert alert-danger">
                    <strong>League could not be created </strong>
            
                    <br><br>
            
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        
            <div>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>