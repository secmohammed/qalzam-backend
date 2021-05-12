   
<div class="tab-pane fade show active" id="profile-personly" role="tabpanel" aria-labelledby="profile-personly-tab"> 

   <div class="inner"> 
      <form action="{{ route('users.update',auth()->id()) }}" method="post">
        @csrf
        @method('PUT')
        <div class="row">
          <div class="col-sm-6 field">
            <label>الإسم</label>
            <input class="form-control" name="name" type="text" placeholder="" value="{{ auth()->user()->name }}">
          </div>
          <div class="col-sm-6 field">
            <label>رقم الجوال</label>
            <input class="form-control" name="mobile" type="number" placeholder="" value="{{ auth()->user()->mobile}}">
          </div>
          <div class="col-sm-6 field">
            <label>البريد الإلكتروني</label>
            <input class="form-control" name="email" type="text" placeholder="" value="{{ auth()->user()->email}}">
          </div>
          <input class="form-control" name="website" type="hidden" placeholder="" value="website">
          <div class="col-sm-12 field">
            <div class="row">
              <div class="col-sm-6">
                <button class="bottom" type="submit">حفظ</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    </div>