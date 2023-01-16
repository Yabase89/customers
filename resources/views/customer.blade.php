<html>
    <head>
        <title>{{$page_type}} Customer</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />
    </head>
    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <h1>{{$page_type}} Customer</h1>
                </div>
                <div class="col-md-6">
                    <a href="{{url('dashboard')}}" class="btn btn-normal">Dashboard</a>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(Session::has('message'))
            <div class="alert alert-{{Session::get('class')}} alert-dismissible fade show" role="alert">
                {{Session::get('message')}}
            </div>
            @endif
            <form method="post" action="{{url('customer-save')}}">
            @csrf
            <div class="form-group">
                <div class="row">
                   <div class="col-md-6">
                        <input type="text" name="first_name" value="" class="form-control" placeholder="First Name" />
                   </div>
                   <div class="col-md-6">
                         <input type="text" name="last_name" value="" class="form-control" placeholder="Last Name" />
                   </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                   <div class="col-md-6">
                          <select name="gender" class="form-control" >
                            <option value="">Gender</option>
                            @foreach($gender_data as $gen)
                            <option value="{{$gen->id}}">{{$gen->gender}}</option>
                            @endforeach
                          </select>
                   </div>
                   <div class="col-md-6">
                          <input type="text" name="mobile_number" value="" class="form-control" placeholder="Mobile Number" onkeypress="return onlyNumberKey(event)" maxlength="10" />
                   </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                   <div class="col-md-6">
                         <input type="text" name="email" value="" class="form-control" placeholder="Email" />
                   </div>
                </div>
            </div>
            <div class="divbreak"><hr></div>
            <div class="row">
                <div class="col-md-6">
                    <h1>Address</h1>
                </div>
            </div>
            <div class="address_data">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="address_type[]" class="form-control" >
                                <option value="">Address Type</option>
                                @foreach($address_types as $add)
                                <option value="{{$add->id}}" @if($add->id==1) selected @endif>{{$add->address_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="street_address[]" value="" class="form-control" placeholder="Street Address" />
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="city[]" value="" class="form-control" placeholder="City" />
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="state[]" value="" class="form-control" placeholder="State" />
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="postcode[]" value="" class="form-control" placeholder="Postcode" onkeypress="return onlyNumberKey(event)" maxlength="4" />
                        </div>
                        <div class="col-md-2">
                            <input type="radio" name="primary" class="isprimary" value="0">Primary
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="address_type[]" class="form-control" >
                                <option value="">Address Type</option>
                                @foreach($address_types as $add)
                                <option value="{{$add->id}}" @if($add->id==2) selected @endif>{{$add->address_type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="street_address[]" value="" class="form-control" placeholder="Street Address" />
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="city[]" value="" class="form-control" placeholder="City" />
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="state[]" value="" class="form-control" placeholder="State" />
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="postcode[]" value="" class="form-control" placeholder="Postcode" onkeypress="return onlyNumberKey(event)" maxlength="4" />
                        </div>
                        <div class="col-md-2">
                            <input type="radio" name="primary" class="isprimary" value="1">Primary
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="total_address" id="total_address" value="2">
            
            <div class="row">
                <div class="col-md-6">
                    <a  class="btn btn-more">Add More</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-6">
                    <button class="btn btn-error" type="reset">Cancel</button>
                    <button class="btn btn-success" type="submit">Save</button>
                </div>
            </div>
            </form>
            <input type="hidden" id="pre_primary" value="1">

                      
        </div>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>    
    <script>
        $(document).ready(function(){
           $(".btn-more").on('click',function(){
               var address_types_html = '';
               var pre_primary = $("#pre_primary").val();
               var next = parseInt(pre_primary) + parseInt(1);
               var total_address = $("#total_address").val();
               var new_toal = parseInt(total_address) + parseInt(1);
               $("#total_address").val(new_toal);
               $("#pre_primary").val(next);
                $.ajax({
                    url: 'get-types',
                    type: 'GET',
                    success: function(ouputData) {
                        address_types_html = ouputData.address_types;
                        var html = '<div class="form-group">'
                                +'<div class="row">'
                                +'<div class="col-md-2">'
                                +'<select name="address_type[]" class="form-control" >'
                                +'<option value="">Address Type</option>'
                                + address_types_html
                                +'</select>'
                                +'</div>'
                                +'<div class="col-md-2">'
                                +'<input type="text" name="street_address[]" value="" class="form-control" placeholder="Street Address" />'
                                +'</div>'
                                +'<div class="col-md-2">'
                                +'<input type="text" name="city[]" value="" class="form-control" placeholder="City" />'
                                +'</div>'
                                +'<div class="col-md-2">'
                                +'<input type="text" name="state[]" value="" class="form-control" placeholder="State" />'
                                +'</div>'
                                +'<div class="col-md-2">'
                                +'<input type="text" name="postcode[]" value="" class="form-control" placeholder="Postcode" onkeypress="return onlyNumberKey(event)" maxlength="4" />'
                                +'</div>'
                                +'<div class="col-md-2">'
                                +'<input type="radio" name="primary" class="isprimary" value="'+next+'">Primary'
                                +'</div>'
                                +'</div>'
                                +'</div>';
                         $(".address_data").append(html); 
                    }
                });
               
                              
           });
        });
        function onlyNumberKey(evt) {
              
              // Only ASCII character in that range allowed
              var ASCIICode = (evt.which) ? evt.which : evt.keyCode
              if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                  return false;
              return true;
          }
    </script>    
    </body>
</html>