<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body>
    <div class="container p-5">
        <h5 class="pb-4">Reservation Page</h5>
        <div class="card mx-3 mt-n5 shadow-lg" style="border-radius: 10px; border-left:8px #007bff solid; border-right: none; border-top:none; border-bottom:none">
          <div class="card-body">
            <h4 class="card-title mb-3 text-primary text-uppercase">Create a Reservation</h4>

            <form onsubmit="submitHandler(event)">
              <div class="row">
                <div class="col">
                  <div class="form-floating mb-3">
                    <input type="number" min="1" max="2" name="guestCount" type="text" class="form-control" id="guestCount" placeholder="Guest Count">
                    <label for="guestCount">Guest Count</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating mb-3">
                    <select onchange="startDateFun()" id="start_date" name="start_date" class="form-select" id="startDate" aria-label="Floating label select example">
                      <option selected value="">Select Check-in Date</option>
                      <option value="2023-08-07">7 August</option>
                      <option value="2023-08-09">9 August</option>
                    </select>
                  </div>
                  <div class="form-floating mb-3">
                    <select name="end_date" class="form-select" id="end_date" aria-label="Floating label select example">
                        <option selected value="">Select Check-out Date</option>
                        <option id="select9" value="2023-08-09">9 August</option>
                        <option value="2023-08-12">12 August</option>
                      </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
              <div class="form-floating mb-3">
                <div class="form-group">
                    <b> Gender</b>
                </div>
                <div class="form-check">
                    <input onchange="bedControl()" name="gender" class="form-check-input" type="checkbox" value="male" id="male">
                    <label class="form-check-label" for="male">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input onchange="bedControl()" name="gender" class="form-check-input" type="checkbox" value="female" id="female">
                    <label class="form-check-label" for="female">
                        Female
                    </label>
                </div>
              </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <b>Room Type</b>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="double" value="double">
                        <label class="form-check-label" for="double">
                          Double Bed
                        </label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="twin" value="twin">
                        <label class="form-check-label" for="twin">
                          Twin Bed
                        </label>
                      </div>
                  </div>
             </div>

              <button type="submit" class="btn btn-success mt-2">Check</button>
            </form>


            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date(Period)</th>
                        <th scope="col">Room Number</th>
                        <th scope="col">Room Type</th>
                        <th scope="col">Number of People</th>
                        <th scope="col">Gender</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                {{-- @dd($reservations); --}}
                @forelse ($reservations as $key => $reservation )
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{date('j', strtotime($reservation->start_date)) }} - {{ date('j', strtotime($reservation->end_date)) }} August</td>
                    <td>{{$reservation->room_id}}</td>
                    <td>{{$reservation->room->type}}</td>
                    <td>{{$reservation->guest_count}}</td>
                    <td>{{$reservation->gender}}</td>
                  </tr>
                @empty
                <tr>
                    <td>Empty</td>
                </tr>
                @endforelse
                </tbody>
              </table>



          </div>
        </div>
      </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script>

    function bedControl(){
       let male = $('#male').is(":checked");
       let female = $('#female').is(":checked");
        if(male && female){
            $('input[name="type"]').prop('checked', false);
        }else {
            document.getElementById("twin").checked = true;
        }
    }


    function startDateFun(){
        document.getElementById("end_date").value = "";
        document.getElementById("end_date").text = "Select Check-out Date";
        let startDate = document.getElementById("start_date").value;
        if (startDate == "2023-08-09") {
            document.getElementById("select9").disabled = true;
        }else{
            document.getElementById("select9").disabled = false;
        }
    }


    function submitHandler(e){
        e.preventDefault();
        let formData= new FormData(e.target);
        let data = Array.from(formData.getAll("gender"));
        let gender = {};
        if (data.length > 0) {
        gender["0"] = data[0];
        if (data.length > 1) {
            gender["1"] = data[1];
        }
        }

        axios.post('http://localhost:80/make-reservation',{
            guestCount : formData.get("guestCount"),
            start_date : formData.get("start_date"),
            end_date : formData.get("end_date"),
            gender : gender,
            type : formData.get("type")
        })
        .then(function (response) {
            if(response.data.status=="error"){
                swal("Error", response.data.message, "error");
            }else {
                swal("Success", response.data.message, "success");
                setTimeout(function(){ location.reload(); }, 1000);
            }
        })
        .catch(function (error) {
            console.log(error);
        });

    }


</script>
</body>
</html>
