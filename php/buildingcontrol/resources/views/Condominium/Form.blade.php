@include ('Layout.header')

    <div class="content-border">
      <div class="card-header">Condominiums Form</div>
      <div class="card-body">
        <form name="form1" method="post" action="{{ route('createCondominium') }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
              <a class="btn btn-primary btn-block col-md-2" href="listCondominiums">List</a>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Name</label>
                <input class="form-control" id="name" name="name" type="text" required="required" aria-describedby="nameHelp" placeholder="Name">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Address</label>
                <input class="form-control" id="adsress" name="address" type="text" required="required" aria-describedby="nameHelp" placeholder="Address">
              </div>
            </div>  
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Manager</label>
                <input class="form-control" id="manager" name="manager" type="text" required="required" aria-describedby="nameHelp" placeholder="Manager">
              </div>
            </div> 
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Logo</label>
                <input class="form-control" id="logo" name="logo" type="file" aria-describedby="nameHelp" placeholder="Name">
              </div>
            </div>  
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName">Phone</label>
                <input class="form-control" id="phone" name="phone" type="text" required="required" aria-describedby="nameHelp" placeholder="Phone">
              </div>
            </div>                                           
          </div>
          <input type="submit" class="btn btn-primary btn-block  col-md-2" value="Save">
        </form>
      </div>
    </div>

@include ('Layout.footer')