<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Bootstrap CSS -->
    <link rel = "stylesheet" href= "{{ url('css/app.css')}}">

    <link rel = "stylesheet" href= "{{ url('css/heatMap.css')}}">
  </head>
  <body>



      <div class="container">
                      <div class="w-100 p-3">
                                    <div class="text-center">
                                          <h1 class="display-3 mt-5"> Heatmap Analytic </h1>

                                      </div>
                                    </div>
                      <br>
                      <!-- errors  -->
                       <div class="form-group row">


                          <!--form1 2calendar and search -->
                          @if(count($dataInDB) > 0)

                                    <div class="w-100 p-3 h-100">
                                      <div class="w-25 p-3 float-left">

                                      </div>
                                        <div >
                                          <div class="form-group mx-auto">



                                      <form class="form-inline" action="{{url('/search')}}" method="post">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          <div class="input-group mb-2 mr-sm-4 mb-sm-0">
                                              <div class="input-group-addon" id="basic-addon1">From</div>
                                                <input type="datetime-local"  id="time" value = "{{ $dateFrom }}" name="From">


                                            </div>


                                          <div class="input-group mb-2 mr-sm-4 mb-sm-0">
                                              <div class="input-group">
                                                  <div class="input-group-addon" id="basic-addon1">To  </div>
                                                    <input type="datetime-local"  id="time" value = "{{ $dateTo }}" name="To">


                                                </div>
                                          </div>



                                              <button type="submit" class="btn btn-success" name="search">Search</button>

                                      </form>
                                      <div class="text-center">
                                      @if ($errors->has('From'))
                                      <p>
                                          <span class="help-block text-danger">
                                              <strong>{{ $errors->first('From') }}</strong>
                                          </span>
                                      </p>

                                      @endif
                                      @if ($errors->has('To'))
                                            <p>
                                          <span class="help-block text-danger">
                                              <strong>{{ $errors->first('To') }}</strong>
                                          </span>
                                      </p>
                                      @endif



                                  </div>
                              </div>
                                        </div>

                                          <div class="w-25 p-3 float-right">

                                          </div>

                                    </div>
                                    <br>

                                    @endif
                                  <!--lable -->


                                    <div class="w-100 ">


                                                      <p class="h4 ml-5 mt-5 pl-5 float-left">Color Scale</p>





                                                              <p class="h4 mr-5 mt-5 pr-5 float-right">Size adjusment</p>



                                            </div>

                                    <br>

                                    <!--color and scaling -->

                                    <div class="w-100 p-3">
                                            <!--left side -->
                                        <div class="w-50 float-left">

                                            <div class="float-left mr-4">
                                                <div class="border-0"><h5>Min</h5></div>
                                                </div>

                                                    <div class="float-left ">

                                                                <h4>
                                                                    <span class="badge badge-primary">1</span>
                                                                    <span class="badge badge-info">2</span>
                                                                    <span class="badge badge-success">3</span>
                                                                    <span class="badge badge-warning">4</span>
                                                                    <span class="badge badge-danger">5</span>

                                                                </h4>

                                                    </div>
                                            <div class="float-left ml-4" >
                                                        <div class= " border-0"><h5>Max</h5></div>
                                                </div>




                                        </div>

                                        <div class="w-50 float-right">
                                            <!--right  side -->
                                            <div class="w-50 p-3 float-left">

                                            </div>
                                            <div class="w-50 float-right">
                                                <div class="mx-auto">

                                                    <div class="btn-group" data-toggle="buttons">
                                                          <label class="btn btn-secondary ">
                                                            <input type="radio" name="size" id="option1" autocomplete="off" value="1/2"> Small
                                                          </label>
                                                          <label class="btn btn-secondary active">
                                                            <input type="radio" name="size" id="option2"  autocomplete="off"   value="1"> Medium
                                                          </label>
                                                          <label class="btn btn-secondary">
                                                            <input type="radio" name="size" id="option3" autocomplete="off" value="2"> Large
                                                          </label>
                                                        </div>
                                                </div>
                                            </div>






                                        </div>





                                    </div>

                                    <!--image -->
                                    <div class="w-100 p-2 m-2" id="heatmapPic">

                                        <div class="text-center">





                                            @if(count($matrix) > 0)

                                            <div id="heatmapContainerWrapper">
                                                     <div id="heatmapContainer">



                                                        @include('heatmapImg')

                                                         </div>
                                             </div>


                                             @else
                                             <img src="{{asset('/img/fish.jpg')}}" width="100%" height="100%" >
                                             </img>

                                             @endif


                                        </div>


                                    </div>

                                    <!-- impot file and Clear DB -->

                                    <div class="w-100 p-3 h-50" id="importFrom">

                                        <!-- Choose .csv file -->
                                        <div class="w-50 p-3 float-left">

                                            <form action="{{url('/importDatas')}}" method="post" enctype="multipart/form-data" >
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <div class="">
                                                                <h4>Choose csv file</h4>
                                                                <div class="input-group">
                                                                    <label class="input-group-btn">
                                                                        <span class="btn btn-secondary ">
                                                                            Browse&hellip; <input type="file" style="display: none;"   name="csvFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                                        </span>
                                                                    </label>

                                                                    <input type="text" class="form-control h-50 w-100" readonly>
                                                                </div>


                                                                <!-- errors in name  -->
                                                                        @if ($errors->has('csvFile'))
                                                                            <span class="help-block text-danger">
                                                                                <strong>{{ $errors->first('csvFile') }}</strong>
                                                                            </span>
                                                                        @endif

                                                            </div>
                                                    </div>

                                        <div class="w-50  float-right">

                                            <div class="mt-5">

                                                <button type="submit" class="btn btn-primary mr-1 h-50 w-25"   name = "btn-import" ><h5>Import</h5></button>

                                            </form>
                                                <form action="{{url('/clearDatas')}}" method="post"   class="float-right pr-5 h-50 w-50">
                                                    <button type="submit" class="btn btn-danger ml-1 h-100 w-100"  onclick="return confirm('Are you sure?')"><h5>Clear DB</h5></button>
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                </form>
                                            </div>
                                        </div>


                                    </div>


















                  </div>
      </div>

      <!--
      <script type="text/javascript" src="{{url('js/build/heatmap.js')}}"></script>
      <script type="text/javascript" src="{{ url('js/matrixToheatMap.js')}}" ></script>
    -->

@if(count($matrix) > 0)

      <script type="text/javascript" src="{{ url('js/size.js')}}" ></script>
 @endif
      <script type="text/javascript" src="{{ url('js/select_file.js')}}" ></script>
    <!-- jQuery first, then Tether, then Bootstrap JS. -->

    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
  </body>
</html>
