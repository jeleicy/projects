@include ('Layout.header')
@foreach ($condominium as $condominium)
    <div class="content-border">
      <div class="card-header">Condominiums Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ route('updateCondominium') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $condominium->id }}">
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listCondominiums">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-10">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name" value="{{ $condominium->name }}">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-10">
                <label for="exampleInputName">Adress</label>
                <input class="form-control" id="adress" name="adress" type="text" required="required" aria-describedby="nameHelp" placeholder="Address" value="{{ $condominium->address }}">
              </div>
            </div>  
            <div class="form-row">
              <div class="col-md-10">
                <label for="exampleInputName">Manager</label>
                <input class="form-control" id="manager" name="manager" type="text" required="required" aria-describedby="nameHelp" placeholder="Manager" value="{{ $condominium->manager }}">
              </div>
            </div> 
            <div class="form-row">
              <div class="col-md-10">
                <label for="exampleInputName">Logo</label>
                <input class="form-control" id="logo" name="logo" type="file" aria-describedby="nameHelp" placeholder="Logo">
              </div>
            </div>  
            <div class="form-row">
              <div class="col-md-10">
                <label for="exampleInputName">Phone</label>
                <input class="form-control" id="phone" name="phone" type="text" required="required" aria-describedby="nameHelp" placeholder="Phone" value="{{ $condominium->phone }}">
              </div>
            </div>                                           
          </div>
          <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
        </form>
      </div>
    </div>
@endforeach
@include ('Layout.footer')