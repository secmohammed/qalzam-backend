   
<div class="tab-pane fade show active" id="profile-personly" role="tabpanel" aria-labelledby="profile-personly-tab"> 

    <div class="inner"> 
       <form action="#" wire:submit.prevent="submit" method="post">
         <div class="row">
           <div class="col-sm-6 field">
             <label>الإسم</label>
             <input class="form-control" wire:model="name" type="text" placeholder="" >
            </div>
           <div class="col-sm-6 field">
             <label>رقم الجوال</label>
             <input class="form-control" wire:model="mobile" type="number" placeholder="" >
           </div>
           <div class="col-sm-6 field">
             <label>البريد الإلكتروني</label>
             <input class="form-control" wire:model="email" type="text" placeholder="" value="mahmoud@gmail.com">
           </div>
           <div class="col-sm-12 field">
             <div class="row">
               <div class="col-sm-6">
                 <button class="bottom"  >حفظ</button>
               </div>
             </div>
           </div>
         </div>
       </form>
     </div>
     </div>