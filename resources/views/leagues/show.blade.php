<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $league->id }}">
                {{ $league->name }}
            </a>
        </h2>
	</div>
	<div id="collapse{{ $league->id }}" class="panel-collapse">
		<div class="panel-body" >
			@if ($league->isCreator)
				<p><strong>Code: </strong> {{ $league->password }}</p>
			@endif
			<p>{{ $league->description }}</p>
			<table class="table table-striped" >
				<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Total Points</th>
				</tr>
				</thead>
				</tbody>
				@if (count($league->memberScores) > 0)
				    @for ($i = 0; $i < count($league->memberScores); $i++)
						<tr>
						    <td>{{ $i + 1 }} </td>
						    <td>{{ $league->memberScores[$i]->name }}</td>
						    <td>{{ $league->memberScores[$i]->totalpoints }}</td>
					    </tr>
					@endfor
				@endif
				</tbody>
			</table>
		</div>
	</div>
</div>