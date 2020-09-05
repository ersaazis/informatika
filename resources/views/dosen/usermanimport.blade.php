@extends(getThemePath("layout.layout"))
@section("content")
    <p>
        <a href="{{cb()->getAdminUrl('users')}}"><i class="fa fa-arrow-left"></i> Back To List</a>
    </p>
    <div class="box box-default">
        <div class="box-header">
            <h1 class="box-title">Import Lecturer Data</h1>
        </div>
        
        <form action="{{cb()->getAdminUrl('users/import/save')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
                <div class="form-group">
                    <label for="InputFile">File CSV</label>
                    <input type="file" required class="form-control" name="import" id="InputFile">
                    <p class="help-block">Make sure the csv file fits the format <a href="{{url('import.csv')}}">import.csv</a></p>
                </div>
            </div>
            <div class="box-footer">
                <input type="submit" class="btn btn-success" value="Import Data">
            </div>
        </form>
    </div>
@endsection