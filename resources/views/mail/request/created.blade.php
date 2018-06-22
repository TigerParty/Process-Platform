<p>There is a new request created</p>

<p>Name: {{ $request->name }}</p>

<p>Email: {{ $request->email }}</p>

<p>Information: {{ $request->information }}</p>

@if($request->step)
<br>
<p>Process: {{ $request->step->process->name }}</p>

<p>Step: {{ $request->step->name }}</p>
@endif