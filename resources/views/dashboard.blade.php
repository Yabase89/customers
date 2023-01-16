<html>
    <head>
        <title>Customer Dashboard</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}" />
    </head>
    <body>
        <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>Customers</h1>
            </div>
            <div class="col-md-5">
                <a href="{{url('add-customer')}}" class="btn btn-normal">Add Customer</a>
            </div>
            <div class="col-md-1">
                    <a href="{{url('logout')}}" class="">Log Out</a>
            </div>
        </div>
            <div class="row list_customers">
                <div class="col-md-12">
                    @if(Session::has('message'))
                    <div class="alert alert-{{Session::get('class')}} alert-dismissible fade show" role="alert">
                        {{Session::get('message')}}
                    </div>
                    @endif
                    <table class="table table-bordered">
                        <thead class="tb_head">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Mobile Number</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $cust)
                                <tr>
                                    <td>{{$cust->first_name}}</td>
                                    <td>{{$cust->last_name}}</td>
                                    <td>{{$cust->mobile_number}}</td>
                                    <td>{{$cust->email}}</td>
                                    <td>
                                        <a href="{{url('add-customer')}}/{{$cust->id}}" class="">Edit</a>
                                        <a href="" class="delete_customer" id="{{$cust->id}}" name="{{$cust->first_name}} {{$cust->last_name}}">Delete</a>
                                    </td>
                                </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </row>  
        </div>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.delete_customer').click(function(event) {
                event.preventDefault();
                var id =  $(this).attr("id");
                var name =  $(this).attr("name");
                swal({
                    title: "Do you want to delete " + name + "?",
                    text: "If you delete this customer, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/delete-customer/'+id,
                            type: 'GET',
                            success: function(ouputData) {
                               if (ouputData == 'success') {
                                location.reload();
                               }
                            }
                        });
                    }
                });
            });
        });
    </script>
    </body>
</html>