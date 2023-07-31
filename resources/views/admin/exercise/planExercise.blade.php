@extends('layouts.adminLayout.admin_design')
@section('content')


    <div class="content-wrapper">
        <style type="text/css">
            .li {
                /*width: 15%;*/
                padding-left: 15px;
                padding-right: 15px;
            }

            td,
            th {
                margin: 15px;
                padding: 10px;
                "

            }

            .select2-selection__choice {
                background-color: #e4e4e4 !important;
                color: black !important;
            }

            .select2 {
                width: 100% !important;
            }

            .select2-container--default .select2-selection--single {
                border-radius: 2px !important;
                max-height: 100% !important;
                border-color: #d2d6de !important;
                height: 32px;
                max-width: 100%;
                min-width: 100% !important;
            }

            .nav-tabs-custom {
                box-shadow: none !important;
            }
        </style>

        <section class="content-header">
            <h2></h2>
        </section>
        <!-- general form elements -->
        <section class="content">
            <div class="">

                <div class="box box-primary">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if ($message = Session::get('message'))
                        @if ($message == 'WorkOut Is Already Exits')
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                    @endif
                    <div class="box-header with-border">
                        <h3 class="box-title">Plan WorkOut</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <form action="{{ url('addplan') }}" method="post" name="formtab" id="formtab">
                            {{ csrf_field() }}
                            <div class="col-lg-12" style="text-align: left;">
                                <div class="col-lg-4">
                                    <!--      <div class="form-group">
                      <label>WorkOut</label>
                      <input type="text" name="workout" class="form-control" placeholder="WorkOut Name" required="" id="workout"><span id="error_username"></span>

                    </div> -->
                                    <div class="form-group">
                                        <label>Workout</label>
                                        <input type="text" name="workout" class="form-control" placeholder="WorkOut Name"
                                            required="" id="workout"><span id="error_username"></span>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Tags </label>

                                        <select class="form-control select2" multiple="" data-placeholder="Select a Tags"
                                            style="width: 100%;" tabindex="-1" aria-hidden="true" name="exerciselevel[]"
                                            required="">

                                            @foreach ($tags as $tag)
                                                <option value="{{ $tag->exerciselevelid }}">{{ $tag->exerciselevel }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                            </div>


                            <br> <br>
                            <div class="col-md-12" style="overflow: auto;">
                                <div class="nav-tabs-custom">
                                    <input type="hidden" id="headeryes" name="headeryes">
                                    <ul class="nav nav-tabs" id="tabs">
                                        <li class="li active"><a href="#day1" data-toggle="tab" onclick="change(2)"
                                                aria-expanded="true">Monday</a></li>
                                        <li class="li"><a href="#day2" data-toggle="tab" onclick="change(3)"
                                                aria-expanded="false">Tuesday</a></li>
                                        <li class="li"><a href="#day3" data-toggle="tab" onclick="change(4)"
                                                aria-expanded="false">Wednesday</a></li>
                                        <li class="li"><a href="#day4" data-toggle="tab" onclick="change(5)"
                                                aria-expanded="false">Thrusday</a></li>
                                        <li class="li"><a href="#day5" data-toggle="tab" aria-expanded="false"
                                                onclick="change(6)">Friday</a></li>
                                        <li class="li"><a href="#day6" data-toggle="tab" aria-expanded="false"
                                                onclick="change(7)">Saturday</a></li>
                                        <!--               <li class="li"><a href="#day7" data-toggle="tab" aria-expanded="false" onclick="change(8)">Sunday</a></li>
     -->
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="day1">

                                            <!-- Post -->
                                            <!-- tab1 -->
                                            <table>
                                                <thead>
                                                    <th></th>
                                                    <th>Header </th>
                                                    <th>Exercise</th>
                                                    <th>Time (Min)</th>
                                                    <th>Set </th>
                                                    <th>Rep (15*12*10)</th>
                                                    <th>Instruction</th>
                                                    <th></th>

                                                </thead>
                                                <tbody id="tbody11">
                                                    <input class="form-control " style="display: none" type="hidden"
                                                        value="1" name="tab1mycount" id="mycounttab1">
                                                    <input type="hidden" name="tab1exerciselevelday"
                                                        id="tab1exerciselevelday" value="1">
                                                    <tr id="tab1firsttr1" class="tab1item">
                                                        <td>
                                                            <div class="form-group">
                                                                <button type="button" id="add1" value="1"
                                                                    class="btn bg-green addtab1"><i
                                                                        class="fa fa-plus">Add</i></button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">
                                                                <input type="text" name="tab1header1"
                                                                    class="form-control header" id="tab1header1"
                                                                    placeholder="Enter Header">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <select class="form-control select2" width="100%"
                                                                    data-live-search="true"
                                                                    data-selected-text-format="count"
                                                                    data-actions-box="true"
                                                                    data-count-selected-text="{0} Exercise Selected"
                                                                    data-header="Select Exercise"
                                                                    name="tab1exercisename1">
                                                                    <option value="" disabled="" selected="">
                                                                        Please select</option>
                                                                    @foreach ($exercise as $exercise1)
                                                                        <option value="{{ $exercise1->exerciseid }}"
                                                                            {{ $exercise1->exerciseid == 1 ? 'selected' : '' }}>
                                                                            {{ $exercise1->exercisename }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab1time1"
                                                                    class="form-control number">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab1set1"
                                                                    class="form-control ">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab1rep1"
                                                                    class="form-control number exerciseset">
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <div class="form-group addafter">

                                                                <input type="text" name="tab1instruction1"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>


                                            </table>
                                            <div class="col-lg-12" style="text-align: center;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        {{--                  <button type="button" id="add1" class="btn bg-green addtab1" ><i class="fa fa-plus">Add</i></button> --}}
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="button" class="btn bg-teal addheader2"
                                                            onclick="addwithheader(1)"><i class="fa fa-plus">Add
                                                                Header</i></button>
                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <div class="tab1rmvitem">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"></div>

                                            </div>
                                            <!--        <div class="col-lg-12" style="text-align: center;">
                    <div class="col-lg-6">
                       <div class="form-group" style="text-align: right">
                      <button type="button"id="add1" class="btn bg-green addtab1" ><i class="fa fa-plus">Add</i></button>
                    </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group"  style="text-align: left">
                      <div class="col-lg-1 tab1rmvitem" style="margin-top: -990px;">

                </div>
                    </div>
                    </div>

                  </div> -->

                                        </div>

                                        <!-- /.tab-pane -->

                                        <!--***********************************tab2************************************************ -->
                                        <div class="tab-pane" id="day2">
                                            <!-- tab2 -->
                                            <table>
                                                <thead>
                                                    <th></th>
                                                    <th>Header </th>
                                                    <th>Exercise</th>
                                                    <th>Time (Min)</th>
                                                    <th>Set </th>
                                                    <th>Rep (15*12*10)</th>
                                                    <th>Instruction</th>
                                                    <th></th>

                                                </thead>
                                                <tbody id="tbody21">
                                                    <input class="form-control" style="display: none" type="hidden"
                                                        value="1" name="tab2mycount" id="mycounttab2">
                                                    <input type="hidden" name="tab2exerciselevelday" value="2">
                                                    <tr id="tab2firsttr1" class="tab2item">
                                                        <td>
                                                            <div class="form-group">
                                                                <button type="button" id="add1" value="1"
                                                                    class="btn bg-green addtab2"><i
                                                                        class="fa fa-plus">Add</i></button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" name="tab2header1"
                                                                    class="form-control header" id="tab2header1"
                                                                    placeholder="Enter Header">

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <select class="form-control select2" width="100%"
                                                                    data-live-search="true"
                                                                    data-selected-text-format="count"
                                                                    data-actions-box="true"
                                                                    data-count-selected-text="{0} Exercise Selected"
                                                                    data-header="Select Exercise"
                                                                    name="tab2exercisename1">
                                                                    <option value="" disabled="" selected="">
                                                                        Please select</option>
                                                                    @foreach ($exercise as $exercise1)
                                                                        <option value="{{ $exercise1->exerciseid }}"
                                                                            {{ $exercise1->exerciseid == 1 ? 'selected' : '' }}>
                                                                            {{ $exercise1->exercisename }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab2time1"
                                                                    class="form-control  number">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab2set1"
                                                                    class="form-control  number">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab2rep1"
                                                                    class="form-control number exerciseset">
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" name="tab2instruction1"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <td></td>


                                                    </tr>
                                                </tbody>

                                            </table>
                                            <!--       <div class="col-lg-12" style="text-align: center;">
                    <div class="col-lg-6">
                       <div class="form-group" style="text-align: right">
                      <button type="button"id="add1" class="btn bg-green addtab2" ><i class="fa fa-plus">Add</i></button>
                    </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group"  style="text-align: left">
                      <div class="col-lg-1 tab2rmvitem" style="margin-top: -990px;">

                </div>
                    </div>
                    </div>

                  </div> -->
                                            <div class="col-lg-12" style="text-align: center;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        {{--                  <button type="button"id="add1" class="btn bg-green addtab2" ><i class="fa fa-plus">Add</i></button> --}}

                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="button" class="btn bg-teal addheader2"
                                                            onclick="addwithheader(2)"><i class="fa fa-plus">Add
                                                                Header</i></button>
                                                    </div>
                                                </div>

                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <div class="tab2rmvitem">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"></div>

                                            </div>
                                        </div>

                                        <!-- /.tab-pane -->
                                        <!--***********************************tab2************************************************ -->
                                        <div class="tab-pane" id="day3">
                                            <!-- tab3 -->
                                            <table>
                                                <thead>
                                                    <th> </th>
                                                    <th>Header </th>
                                                    <th>Exercise</th>
                                                    <th>Time (Min)</th>
                                                    <th>Set </th>
                                                    <th>Rep (15*12*10)</th>
                                                    <th>Instruction</th>
                                                    <th></th>
                                                </thead>
                                                <tbody id="tbody31">
                                                    <input class="form-control" style="display: none" type="hidden"
                                                        value="1" name="tab3mycount" id="mycounttab3">
                                                    <input type="hidden" name="tab3exerciselevelday" value="3">
                                                    <tr id="tab3firsttr1" class="tab3item">
                                                        <td>
                                                            <div class="form-group">
                                                                <button type="button"id="add1" value="1"
                                                                    class="btn bg-green addtab3"><i
                                                                        class="fa fa-plus">Add</i></button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" name="tab3header1"
                                                                    class="form-control header" id="tab3header1"
                                                                    placeholder="Enter Header">

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <select
                                                                    class="form-control select2"data-live-search="true"
                                                                    data-selected-text-format="count"
                                                                    data-actions-box="true"
                                                                    data-count-selected-text="{0} Exercise Selected"
                                                                    data-header="Select Exercise"
                                                                    name="tab3exercisename1">
                                                                    <option value="" disabled="" selected="">
                                                                        Please select</option>
                                                                    @foreach ($exercise as $exercise1)
                                                                        <option
                                                                            value="{{ $exercise1->exerciseid }}"{{ $exercise1->exerciseid == 1 ? 'selected' : '' }}>
                                                                            {{ $exercise1->exercisename }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0"name="tab3time1"
                                                                    class="form-control  number">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab3set1"
                                                                    class="form-control  ">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab3rep1"
                                                                    class="form-control number exerciseset">
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" name="tab3instruction1"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <th></th>

                                                    </tr>
                                                </tbody>

                                            </table>
                                            <div class="col-lg-12" style="text-align: center;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        {{--                  <button type="button"id="add1" class="btn bg-green addtab3" ><i class="fa fa-plus">Add</i></button> --}}
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="button" class="btn bg-teal addheader2"
                                                            onclick="addwithheader(3)"><i class="fa fa-plus">Add
                                                                Header</i></button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <div class="tab3rmvitem">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"></div>

                                            </div>
                                            <!--   <div class="col-lg-12" style="text-align: center;">
                    <div class="col-lg-6">
                       <div class="form-group" style="text-align: right">
                      <button type="button"id="add1" class="btn bg-green addtab3" ><i class="fa fa-plus">Add</i></button>
                    </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group"  style="text-align: left">
                      <div class="col-lg-1 tab3rmvitem" style="margin-top: -990px;">

                </div>
                    </div>
                    </div>

                  </div> -->
                                        </div>
                                        <!-- /.tab-pane -->

                                        <!--***********************************tab4************************************************ -->
                                        <div class="tab-pane" id="day4">
                                            <!-- tab4 -->
                                            <table>
                                                <thead>
                                                    <th> </th>
                                                    <th>Header </th>
                                                    <th>Exercise</th>
                                                    <th>Time (Min)</th>
                                                    <th>Set </th>
                                                    <th>Rep (15*12*10)</th>
                                                    <th>Instruction</th>
                                                    <th></th>

                                                </thead>
                                                <tbody id="tbody41">
                                                    <input class="form-control" style="display: none" type="hidden"
                                                        value="1" name="tab4mycount" id="mycounttab4">
                                                    <input type="hidden" name="tab4exerciselevelday" value="4">
                                                    <tr id="tab4firsttr1" class="tab4item">
                                                        <td>
                                                            <div class="form-group">
                                                                <button type="button" id="add1" value="1"
                                                                    class="btn bg-green addtab4"><i
                                                                        class="fa fa-plus">Add</i></button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" name="tab4header1"
                                                                    class="form-control header" id="tab4header1"
                                                                    placeholder="Enter Header">

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <select
                                                                    class="form-control select2"data-live-search="true"
                                                                    data-selected-text-format="count"
                                                                    data-actions-box="true"
                                                                    data-count-selected-text="{0} Exercise Selected"
                                                                    data-header="Select Exercise"
                                                                    name="tab4exercisename1">
                                                                    <option value="" disabled="" selected="">
                                                                        Please select</option>
                                                                    @foreach ($exercise as $exercise1)
                                                                        <option value="{{ $exercise1->exerciseid }}"
                                                                            {{ $exercise1->exerciseid == 1 ? 'selected' : '' }}>
                                                                            {{ $exercise1->exercisename }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab4time1"
                                                                    class="form-control  number">
                                                            </div>
                                                        </td>
                                                        <td>

                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab4set1"
                                                                    class="form-control number ">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab4rep1"
                                                                    class="form-control number exerciseset">
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <div class="form-group ">

                                                                <input type="text" name="tab4instruction1"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <th></th>

                                                    </tr>
                                                </tbody>

                                            </table>
                                            <div class="col-lg-12" style="text-align: center;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        {{--                  <button type="button"id="add1" class="btn bg-green addtab4" ><i class="fa fa-plus">Add</i></button> --}}
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="button" class="btn bg-teal addheader2"
                                                            onclick="addwithheader(4)"><i class="fa fa-plus">Add
                                                                Header</i></button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <div class="tab4rmvitem">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"></div>

                                            </div>
                                        </div>

                                        <!--***********************************tab2************************************************ -->
                                        <div class="tab-pane" id="day5">
                                            <!-- tab5 -->
                                            <table>
                                                <thead>
                                                    <th> </th>
                                                    <th>Header </th>
                                                    <th>Exercise</th>
                                                    <th>Time (Min)</th>
                                                    <th>Set </th>
                                                    <th>Rep (15*12*10)</th>
                                                    <th>Instruction</th>
                                                    <th></th>


                                                </thead>
                                                <tbody id="tbody51">
                                                    <input class="form-control" style="display: none" type="hidden"
                                                        value="1" name="tab5mycount" id="mycounttab5">
                                                    <input type="hidden" name="tab5exerciselevelday" value="5">
                                                    <tr id="tab5firsttr1" class="tab5item">
                                                        <td>
                                                            <div class="form-group">
                                                                <button type="button" value="1" id="add1"
                                                                    class="btn bg-green addtab5"><i
                                                                        class="fa fa-plus">Add</i></button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" name="tab5header1"
                                                                    class="form-control header" id="tab5header1"
                                                                    placeholder="Enter Header">

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <select
                                                                    class="form-control select2"data-live-search="true"
                                                                    data-selected-text-format="count"
                                                                    data-actions-box="true"
                                                                    data-count-selected-text="{0} Exercise Selected"
                                                                    data-header="Select Exercise"
                                                                    name="tab5exercisename1">
                                                                    <option value="" disabled="" selected="">
                                                                        Please select</option>
                                                                    @foreach ($exercise as $exercise1)
                                                                        <option value="{{ $exercise1->exerciseid }}"
                                                                            {{ $exercise1->exerciseid == 1 ? 'selected' : '' }}>
                                                                            {{ $exercise1->exercisename }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab5time1"
                                                                    class="form-control  number">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab5set1"
                                                                    class="form-control number ">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab5rep1"
                                                                    class="form-control number exerciseset">
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <div class="form-group ">

                                                                <input type="text" name="tab5instruction1"
                                                                    class="form-control">
                                                            </div>
                                                        </td>

                                                        <th></th>
                                                    </tr>
                                                </tbody>

                                            </table>
                                            <div class="col-lg-12" style="text-align: center;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-1">
                                                    {{--                   <div class="form-group" > --}}
                                                    {{--                  <button type="button"id="add1" class="btn bg-green addtab5" ><i class="fa fa-plus">Add</i></button> --}}
                                                    {{--                </div> --}}
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="button" class="btn bg-teal addheader2"
                                                            onclick="addwithheader(5)"><i class="fa fa-plus">Add
                                                                Header</i></button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <div class="tab5rmvitem">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"></div>

                                            </div>
                                        </div>



                                        <!--***********************************tab2************************************************ -->
                                        <div class="tab-pane" id="day6">
                                            <!-- tab6 -->
                                            <table>
                                                <thead>
                                                    <th> </th>
                                                    <th>Header </th>
                                                    <th>Exercise</th>
                                                    <th>Time (Min)</th>
                                                    <th>Set </th>
                                                    <th>Rep (15*12*10)</th>
                                                    <th>Instruction</th>
                                                    <th></th>
                                                </thead>
                                                <tbody id="tbody61">
                                                    <input class="form-control " style="display: none" type="hidden"
                                                        value="1" name="tab6mycount" id="mycounttab6">
                                                    <input type="hidden" name="tab6exerciselevelday" value="6">
                                                    <tr id="tab6firsttr1" class="tab6item">
                                                        <td>
                                                            <div class="form-group">
                                                                <button type="button" value="1" id="add1"
                                                                    class="btn bg-green addtab6"><i
                                                                        class="fa fa-plus">Add</i></button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" name="tab6header1"
                                                                    class="form-control header" id="tab6header1"
                                                                    placeholder="Enter Header">

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <select class="form-control select2"
                                                                    data-live-search="true"
                                                                    data-selected-text-format="count"
                                                                    data-actions-box="true"
                                                                    data-count-selected-text="{0} Exercise Selected"
                                                                    data-header="Select Exercise"
                                                                    name="tab6exercisename1">
                                                                    <option value="" disabled="" selected="">
                                                                        Please select</option>
                                                                    @foreach ($exercise as $exercise1)
                                                                        <option
                                                                            value="{{ $exercise1->exerciseid }}"{{ $exercise1->exerciseid == 1 ? 'selected' : '' }}>
                                                                            {{ $exercise1->exercisename }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab6time1"
                                                                    class="form-control  number">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab6set1"
                                                                    class="form-control number ">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab6rep1"
                                                                    class="form-control number exerciseset">
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <div class="form-group ">

                                                                <input type="text" name="tab6instruction1"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <th></th>

                                                    </tr>
                                                </tbody>

                                            </table>
                                            <div class="col-lg-12" style="text-align: center;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-1">
                                                    {{--                   <div class="form-group" > --}}
                                                    {{--                  <button type="button"id="add1" class="btn bg-green addtab6" ><i class="fa fa-plus">Add</i></button> --}}
                                                    {{--                </div> --}}
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="button" class="btn bg-teal addheader2"
                                                            onclick="addwithheader(6)"><i class="fa fa-plus">Add
                                                                Header</i></button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <div class="tab6rmvitem">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"></div>

                                            </div>
                                        </div>

                                        <!--***********************************tab2************************************************ -->
                                        <div class="tab-pane" id="day7">
                                            <!-- tab7 -->
                                            <table>
                                                <thead>
                                                    <th> </th>
                                                    <th>Header </th>
                                                    <th>Exercise</th>
                                                    <th>Time (Min)</th>
                                                    <th>Set </th>
                                                    <th>Rep (15*12*10)</th>
                                                    <th>Instruction</th>
                                                    <th></th>

                                                </thead>
                                                <tbody id="tbody71">
                                                    <input class="form-control" style="display: none" type="hidden"
                                                        value="1" name="tab7mycount" id="mycounttab7">
                                                    <input type="hidden" name="tab7exerciselevelday" value="7">
                                                    <tr id="tab7firsttr1" class="tab7item">
                                                        <td>
                                                            <div class="form-group">
                                                                <button type="button" value="1" id="add1"
                                                                    class="btn bg-green addtab7"><i
                                                                        class="fa fa-plus">Add</i></button>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" name="tab7header1"
                                                                    class="form-control header" id="tab7header1"
                                                                    placeholder="Enter Header">

                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <select class="form-control select2"
                                                                    data-live-search="true"
                                                                    data-selected-text-format="count"
                                                                    data-actions-box="true"
                                                                    data-count-selected-text="{0} Exercise Selected"
                                                                    data-header="Select Exercise"
                                                                    name="tab7exercisename1">
                                                                    <option value="" disabled="" selected="">
                                                                        Please select</option>
                                                                    @foreach ($exercise as $exercise1)
                                                                        <option value="{{ $exercise1->exerciseid }}"
                                                                            {{ $exercise1->exerciseid == 1 ? 'selected' : '' }}>
                                                                            {{ $exercise1->exercisename }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab7time1"
                                                                    class="form-control  number">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab7set1"
                                                                    title="Please Enter in formate like 12*23*34"class="form-control number ">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="form-group">

                                                                <input type="text" value="0" name="tab7rep1"
                                                                    class="form-control number exerciseset">
                                                            </div>
                                                        </td>


                                                        <td>
                                                            <div class="form-group ">

                                                                <input type="text" name="tab7instruction1"
                                                                    class="form-control">
                                                            </div>
                                                        </td>
                                                        <th></th>


                                                    </tr>
                                                </tbody>

                                            </table>
                                            <div class="col-lg-12" style="text-align: center;">
                                                <div class="col-lg-4"></div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <button type="button"id="add1"
                                                            class="btn bg-green addtab7"><i
                                                                class="fa fa-plus">Add</i></button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <button type="button" class="btn bg-teal addheader2"
                                                            onclick="addwithheader(7)"><i class="fa fa-plus">Add
                                                                Header</i></button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <div class="form-group">
                                                        <div class="tab7rmvitem">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4"></div>

                                            </div>
                                        </div>

                                        <!--***********************************tab2************************************************ -->
                                    </div>
                                    <div class="col-lg-12 box">
                                        <center>
                                            <br><br>
                                            <div class="form-group">
                                                <input type="button" name="day1btn" id="day1btn"
                                                    class="btn bg-orange  " value="Tuesday">
                                                <input type="button" name="day2btn" id="day2btn"
                                                    class="btn bg-orange " style="display: none;" value="Wednesday">
                                                <input type="button" name="day3btn" id="day3btn"
                                                    class="btn bg-orange "style="display: none;" value="Thrusday">
                                                <input type="button" name="day4btn" id="day4btn"
                                                    class="btn bg-orange " style="display: none;" value="Friday">
                                                <input type="button" name="day5btn" id="day5btn"
                                                    class="btn bg-orange "style="display: none;" value="Saturday">
                                                <!--     <input type="button" name="day6btn"  id="day6btn" class="btn bg-orange "style="display: none;" value="Sunday"> -->

                                                <input type="submit" name="submit" id="day7btn"
                                                    class="btn bg-orange" style="display: none;">
                                            </div>
                                        </center>
                        </form>
                    </div>
                    <!-- /.tab-content -->
                </div>


                <!-- /.nav-tabs-custom -->
            </div>
    </div>
    </div>

    </section>
    </div>
    <script type="text/javascript">
        function addwithheader(tab) {
            $('#headeryes').val(1);
            $(".addtab" + tab + ':last').trigger('click');
        }
        $('#day1btn').on('click', function() {
            $('a[href="#day2"]').click();

            $('#day1btn').hide();
            $('#day2btn').show();
        });
        $('#day2btn').on('click', function() {
            $('a[href="#day3"]').click();
            $('#day2btn').hide();
            $('#day3btn').show();
        });

        $('#day3btn').on('click', function() {
            $('a[href="#day4"]').click();
            $('#day3btn').hide();
            $('#day4btn').show();
        });
        $('#day4btn').on('click', function() {
            $('a[href="#day5"]').click();
            $('#day4btn').hide();
            $('#day5btn').show();
        });
        $('#day5btn').on('click', function() {
            $('a[href="#day6"]').click();
            $('#day5btn').hide();
            $('#day7btn').show();
        });
        //  $('#day6btn').on('click',function(){
        // $('a[href="#day7"]').click();
        //  $('#day6btn').hide();
        //  $('#day7btn').show();
        //  });
        //
        function change(day) {

            var tabs = $("#tabs .active a").attr('href');

            for (var i = 1; i <= 7; i++) {
                $('#day' + i + 'btn').hide();
            }

            var dayhide = day - 1;
            $('#day' + dayhide + 'btn').show();
            // alert(tabs);

        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            // **********************************fottab1*********************************
            var counttab1 = 1;
            var countheader1 = 1;
            $(document).on("click", '.addtab1', function() {

                var mycount = $(this).val();
                // if ($("#mycounttab1").val()!='')
                // {
                //   counttab1= $("#mycounttab1").val();
                // }

                counttab1++;
                var ap = '';
                if ($("#headeryes").val() == 1) {
                    countheader1++;
                    ap += '<tbody id="tbody1' + countheader1 + '" >';
                }
                ap += '<tr id="tab1firsttr' + counttab1 + '" class="tab1item">';
                if ($("#headeryes").val() == 1) {
                    ap += '<td><div class="form-group"><button type="button" id="add1" value="' +
                        countheader1 +
                        '" class="btn bg-green addtab1" ><i class="fa fa-plus">Add</i></button></div></td><td><div class="form-group"><input type="text" name="tab1header' +
                        counttab1 + '" class="form-control header"  id="tab1header' + counttab1 +
                        '" placeholder="Enter Header"></div></td>';

                } else {
                    ap += '<td></td><td></td>';
                }
                ap +=
                    '<td><div class="form-group"><select class="form-control select2" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" data-live-search="true"  name="tab1exercisename' +
                    counttab1 +
                    '"><option value="" disabled  selected="">Please select</option><?php foreach ($exercise as $exercisetab1) {
                        echo '<option value="' . $exercisetab1->exerciseid . '">' . $exercisetab1->exercisename . '</option> ';
                    } ?>;';
                ap += '</select></div></td><td><div class="form-group"><input type="text" name="tab1time' +
                    counttab1 +
                    '" class="form-control"></div></td><td><div class="form-group"><input type="text" name="tab1set' +
                    counttab1 +
                    '" class="form-control number"></div></td><td><div class="form-group"><input id="tab1rep' +
                    counttab1 + '"type="text" name="tab1rep' + counttab1 +
                    '" class="form-control number exerciseset"></div></td> <td><div class="form-group"><input type="text" name="tab1instruction' +
                    counttab1 + '" class="form-control"></div></td><td>' +
                    '<button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab1(' +
                    counttab1 + ')"><i class="fa fa-minus"></i></button></td></tr>';

                if ($("#headeryes").val() == 1) {
                    ap += '</tbody>';
                    $('#tbody1' + (countheader1 - 1)).after(ap);
                    $("#headeryes").val(0);
                } else {
                    $('#tbody1' + mycount).append(ap);
                }

                $('.select2').select2();

                // var rmv = '<div id="tab1rmvbtn'+counttab1+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab1('+counttab1+')"><i class="fa fa-close">Remove</i></button></div>';

                count2 = counttab1 - 1;
                // alert(counttab1);
                $("#tab1rmvbtn" + count2).hide();

                // $(".tab1rmvitem:last").after(rmv);

                $("#mycounttab1").val(counttab1);
                // var count2 = counttab1-1;

                // $("#firstremove"+count2).hide();
                // $(".remove:last").after(rmv);

                // $("#mycount").val(counttab1);
                $("#tab1rep" + counttab1).keypress(function(e) {
                    var keyCode = e.which;
                    /*
                    8 - (backspace)
                    32 - (space)
                    48-57 - (0-9)Numbers
                    */
                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });

                //   $('input[name="tab1set'+counttab1+'"').keypress(function(e){
                //   var keyCode = e.which;

                //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                //     return false;
                //   }
                // });
                $('input[name="tab1time' + counttab1 + '"').keypress(function(e) {
                    var keyCode = e.which;

                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
            });

        });

        function removetab1(counttab1) {

            $('#tab1firsttr' + counttab1).remove();
            $('#tab1rmvbtn' + counttab1).remove();


            // var count3 = counttab1-1;
            // $("#tab1rmvbtn"+count3).show();
            // $("#mycounttab1").val(count3);

        }



        // ******************************fortab1******************************
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // **********************************fottab2*********************************
            var counttab2 = 1;
            var countheader2 = 1;

            $(document).on("click", '.addtab2', function() {

                var mycount = $(this).val();
                //     if ($("#mycounttab2").val()!='')
                // {
                //   counttab2= $("#mycounttab2").val();
                //
                // }

                counttab2++;
                var mycount = $(this).val();
                var ap = '';
                if ($("#headeryes").val() == 1) {
                    countheader2++;
                    ap += '<tbody id="tbody2' + countheader2 + '" >';
                }
                ap += '<tr id="tab2firsttr' + counttab2 + '" class="tab2item">';
                if ($("#headeryes").val() == 1) {
                    ap += '<td><div class="form-group"> <button type="button" id="add1" value="' +
                        countheader2 +
                        '" class="btn bg-green addtab2" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab2header' +
                        counttab2 + '" class="form-control header"  id="tab2header' + counttab2 +
                        '" placeholder="Enter Header"></div></td>';

                } else {
                    ap += '<td></td><td></td>';
                }

                ap +=
                    '<td><div class="form-group"><select class="form-control select2"  data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" data-live-search="true"  name="tab2exercisename' +
                    counttab2 +
                    '"><option value="" disabled="" selected="">Please select</option><?php foreach ($exercise as $exercisetab2) {
                        echo '<option value="' . $exercisetab2->exerciseid . '">' . $exercisetab2->exercisename . '</option> ';
                    }
                    ?> <
                    /select></div > <
                    /td><td><div class="form-group"><input type="text" name="tab2time'+counttab2+'" class="form-control"></div >
                    <
                    /td><td><div class="form-group"><input type="text" name="tab2set'+counttab2+'" class="form-control number"></div >
                    <
                    /td><td><div class="form-group"><input id="tab2rep'+counttab2+'"type="text" name="tab2rep'+counttab2+'" class="form-control number exerciseset"></div >
                    <
                    /td> <td><div class="form-group"><input type="text" name="tab2instruction'+counttab2+'" class="form-control"></div >
                    < /td>' +
                '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab2(' +
                counttab2 + ')" ><i class="fa fa-minus"></i></button></td></tr>';

                if ($("#headeryes").val() == 1) {
                    ap += '</tbody>';
                    $('#tbody2' + (countheader2 - 1)).after(ap);
                    $("#headeryes").val(0);
                } else {
                    $('#tbody2' + mycount).append(ap);
                }

                // $('.tab2item:last').after(ap);
                $('.select2').select2()

                // var rmv = '<div id="tab2rmvbtn'+counttab2+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab2('+counttab2+')" ><i class="fa fa-close">Remove</i></button></div>';

                count2 = counttab2 - 1;
                // alert(counttab2);
                $("#tab2rmvbtn" + count2).hide();

                // $(".tab2rmvitem:last").after(rmv);

                $("#mycounttab2").val(counttab2);
                // var count2 = counttab1-1;

                // $("#firstremove"+count2).hide();
                // $(".remove:last").after(rmv);

                // $("#mycount").val(counttab1);
                $("#tab2rep" + counttab2).keypress(function(e) {
                    var keyCode = e.which;
                    /*
                    8 - (backspace)
                    32 - (space)
                    48-57 - (0-9)Numbers
                    */
                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
                //   $('input[name="tab2set'+counttab2+'"').keypress(function(e){
                //   var keyCode = e.which;

                //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                //     return false;
                //   }
                // });
                $('input[name="tab2time' + counttab2 + '"').keypress(function(e) {
                    var keyCode = e.which;

                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
            });

        });

        function removetab2(counttab2) {
            // alert(counttab2);

            $('#tab2firsttr' + counttab2).remove();
            $('#tab2rmvbtn' + counttab2).remove();


            // var count3 = counttab2-1;
            // $("#tab2rmvbtn"+count3).show();
            // $("#mycounttab2").val(count3);

        }
    </script>
    <!-- *******************************************tab3******************************** -->
    <script type="text/javascript">
        $(document).ready(function() {
            // **********************************fottab2*********************************
            var counttab3 = 1;
            var countheader3 = 1;

            $(document).on("click", '.addtab3', function() {

                var mycount = $(this).val();
                //     if ($("#mycounttab3").val()!='')
                // {
                //   counttab2= $("#mycounttab3").val();
                //
                // }

                counttab3++;

                var ap = '';
                if ($("#headeryes").val() == 1) {
                    countheader3++;
                    ap += '<tbody id="tbody3' + countheader3 + '" >';
                }
                ap += '<tr id="tab3firsttr' + counttab3 + '" class="tab3item">';
                if ($("#headeryes").val() == 1) {
                    ap += '<td><div class="form-group" ><button type="button" value="' + countheader3 +
                        '" id="add1" class="btn bg-green addtab3" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab3header' +
                        counttab3 + '" class="form-control header"  id="tab3header' + counttab3 +
                        '" placeholder="Enter Header"></div></td>';

                } else {
                    ap += '<td></td>';
                }
                // $("#headeryes").val(0);
                ap +=
                    '<td><div class="form-group"><select class="form-control select2" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  data-live-search="true"  name="tab3exercisename' +
                    counttab3 +
                    '"><option value="" disabled="" selected="">Please select</option>         <?php foreach ($exercise as $exercisetab3) {
                        echo '<option value="' . $exercisetab3->exerciseid . '">' . $exercisetab3->exercisename . '</option> ';
                    }
                    ?> <
                    /select></div > <
                    /td><td><div class="form-group"><input type="text" name="tab3time'+counttab3+'" class="form-control"></div >
                    <
                    /td><td><div class="form-group"><input type="text" name="tab3set'+counttab3+'" class="form-control number"></div >
                    <
                    /td><td><div class="form-group"><input id="tab3rep'+counttab3+'"type="text" name="tab3rep'+counttab3+'" class="form-control number exerciseset"></div >
                    <
                    /td> <td><div class="form-group"><input type="text" name="tab3instruction'+counttab3+'" class="form-control"></div >
                    < /td>' +
                '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab3(' +
                counttab3 + ')" ><i class="fa fa-minus"></i></button></td></tr>';

                if ($("#headeryes").val() == 1) {
                    ap += '</tbody>';
                    $('#tbody3' + (countheader3 - 1)).after(ap);
                    $("#headeryes").val(0);
                } else {
                    $('#tbody3' + mycount).append(ap);
                }

                // $('.tab3item:last').after(ap);
                $('.select2').select2()


                var rmv = '<div id="tab3rmvbtn' + counttab3 +
                    '"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab3(' +
                    counttab3 + ')" ><i class="fa fa-close">Remove</i></button></div>';

                count2 = counttab3 - 1;
                // alert(counttab3);
                $("#tab3rmvbtn" + count2).hide();

                // $(".tab3rmvitem:last").after(rmv);

                $("#mycounttab3").val(counttab3);
                // var count2 = counttab1-1;

                // $("#firstremove"+count2).hide();
                // $(".remove:last").after(rmv);

                // $("#mycount").val(counttab1);
                $("#tab3rep" + counttab2).keypress(function(e) {
                    var keyCode = e.which;
                    /*
                    8 - (backspace)
                    32 - (space)
                    48-57 - (0-9)Numbers
                    */
                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
                //  $('input[name="tab3set'+counttab3+'"').keypress(function(e){
                //   var keyCode = e.which;

                //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                //     return false;
                //   }
                // });
                $('input[name="tab3time' + counttab3 + '"').keypress(function(e) {
                    var keyCode = e.which;

                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
            });

        });

        function removetab3(counttab3) {
            // alert(counttab3);

            $('#tab3firsttr' + counttab3).remove();
            $('#tab3rmvbtn' + counttab3).remove();


            // var count3 = counttab3-1;
            // $("#tab3rmvbtn"+count3).show();
            // $("#mycounttab3").val(count3);

        }
    </script>
    <!-- **********************************************************tab4************************ -->
    <script type="text/javascript">
        $(document).ready(function() {
            // **********************************fottab2*********************************
            var counttab4 = 1;
            var countheader4 = 1;

            $(document).on("click", '.addtab4', function() {

                var mycount = $(this).val();
                //     if ($("#mycounttab4").val()!='')
                // {
                //   counttab4= $("#mycounttab4").val();
                //
                // }

                counttab4++;
                var ap = '';
                if ($("#headeryes").val() == 1) {
                    countheader4++;
                    ap += '<tbody id="tbody4' + countheader4 + '" >';
                }
                ap += '<tr id="tab4firsttr' + counttab4 + '" class="tab4item">';
                if ($("#headeryes").val() == 1) {
                    ap += '<td><button type="button" value="' + countheader4 +
                        '" id="add1" class="btn bg-green addtab4" ><i class="fa fa-plus">Add</i></button></td><td><div class="form-group"><input type="text" name="tab4header' +
                        counttab4 + '" class="form-control header"  id="tab4header' + counttab4 +
                        '" placeholder="Enter Header"></div></td>';

                } else {
                    ap += '<td></td><td></td>';
                }
                // $("#headeryes").val(0);
                ap +=
                    '<td><div class="form-group"><select class="form-control select2"  data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" data-live-search="true"  name="tab4exercisename' +
                    counttab4 +
                    '"><option value="" disabled="" selected="">Please select</option>         <?php foreach ($exercise as $exercisetab4) {
                        echo '<option value="' . $exercisetab4->exerciseid . '">' . $exercisetab4->exercisename . '</option> ';
                    }
                    ?> <
                    /select></div > <
                    /td><td><div class="form-group"><input type="text" name="tab4time'+counttab4+'" class="form-control"></div >
                    <
                    /td><td><div class="form-group"><input type="text" name="tab4set'+counttab4+'" class="form-control number"></div >
                    <
                    /td><td><div class="form-group"><input id="tab4rep'+counttab4+'"type="text" name="tab4rep'+counttab4+'" class="form-control  exerciseset"></div >
                    <
                    /td> <td><div class="form-group"><input type="text" name="tab4instruction'+counttab4+'" class="form-control"></div >
                    < /td>' +
                '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab4(' +
                counttab4 + ')" ><i class="fa fa-minus"></i></button></td></tr>';

                if ($("#headeryes").val() == 1) {
                    ap += '</tbody>';
                    $('#tbody4' + (countheader4 - 1)).after(ap);
                    $("#headeryes").val(0);
                } else {
                    $('#tbody4' + mycount).append(ap);
                }
                // $('.tab4item:last').after(ap);
                $('.select2').select2()

                // var rmv = '<div id="tab4rmvbtn'+counttab4+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab4('+counttab4+')" ><i class="fa fa-close">Remove</i></button></div>';

                count2 = counttab4 - 1;
                // alert(counttab4);
                $("#tab4rmvbtn" + count2).hide();

                // $(".tab4rmvitem:last").after(rmv);

                $("#mycounttab4").val(counttab4);
                // var count2 = counttab1-1;

                // $("#firstremove"+count2).hide();
                // $(".remove:last").after(rmv);

                // $("#mycount").val(counttab1);
                $("#tab4rep" + counttab4).keypress(function(e) {
                    var keyCode = e.which;
                    /*
                    8 - (backspace)
                    32 - (space)
                    48-57 - (0-9)Numbers
                    */
                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
                //  $('input[name="tab4set'+counttab4+'"').keypress(function(e){
                //   var keyCode = e.which;

                //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                //     return false;
                //   }
                // });
                $('input[name="tab4time' + counttab4 + '"').keypress(function(e) {
                    var keyCode = e.which;

                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
            });

        });

        function removetab4(counttab4) {
            // alert(counttab4);

            $('#tab4firsttr' + counttab4).remove();
            $('#tab4rmvbtn' + counttab4).remove();


            // var count3 = counttab4-1;
            // $("#tab4rmvbtn"+count3).show();
            // $("#mycounttab4").val(count3);

        }
    </script>
    <!-- ********************************tab5***************************************** -->
    <script type="text/javascript">
        $(document).ready(function() {
            // **********************************fottab5*********************************
            var counttab5 = 1;
            var countheader5 = 1;

            $(document).on("click", '.addtab5', function() {

                var mycount = $(this).val();
                //     if ($("#mycounttab5").val()!='')
                // {
                //   counttab5= $("#mycounttab5").val();
                //
                // }

                counttab5++;
                var ap = '';
                if ($("#headeryes").val() == 1) {
                    countheader5++;
                    ap += '<tbody id="tbody5' + countheader5 + '" >';
                }
                ap += '<tr id="tab5firsttr' + counttab5 + '" class="tab5item">';
                if ($("#headeryes").val() == 1) {
                    ap += '<td> <div class="form-group" ><button type="button" value="' + countheader5 +
                        '" id="add1" class="btn bg-green addtab5" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab5header' +
                        counttab5 + '" class="form-control header"  id="tab5header' + counttab5 +
                        '" placeholder="Enter Header"></div></td>';

                } else {
                    ap += '<td></td><td></td>';
                }
                // $("#headeryes").val(0);
                ap +=
                    '<td><div class="form-group"><select class="form-control select2" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  data-live-search="true"  name="tab5exercisename' +
                    counttab5 +
                    '"><option value="" disabled="" selected="">Please select</option>         <?php foreach ($exercise as $exercisetab5) {
                        echo '<option value="' . $exercisetab5->exerciseid . '">' . $exercisetab5->exercisename . '</option> ';
                    }
                    ?> <
                    /select></div > <
                    /td><td><div class="form-group"><input type="text" name="tab5time'+counttab5+'" class="form-control"></div >
                    <
                    /td><td><div class="form-group"><input type="text" name="tab5set'+counttab5+'" class="form-control number"></div >
                    <
                    /td><td><div class="form-group"><input id="tab5rep'+counttab5+'"type="text" name="tab5rep'+counttab5+'" class="form-control number exerciseset"></div >
                    <
                    /td> <td><div class="form-group"><input type="text" name="tab5instruction'+counttab5+'" class="form-control"></div >
                    < /td>' +
                '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab5(' +
                counttab5 + ')" ><i class="fa fa-minus"></i></button></td></tr>';

                if ($("#headeryes").val() == 1) {
                    ap += '</tbody>';
                    $('#tbody5' + (countheader5 - 1)).after(ap);
                    $("#headeryes").val(0);
                } else {
                    $('#tbody5' + mycount).append(ap);
                }
                // $('.tab5item:last').after(ap);
                $('.select2').select2()

                var rmv = '<div id="tab5rmvbtn' + counttab5 +
                    '"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab5(' +
                    counttab5 + ')" ><i class="fa fa-close">Remove</i></button></div>';

                count2 = counttab5 - 1;
                // alert(counttab5);
                $("#tab5rmvbtn" + count2).hide();

                // $(".tab5rmvitem:last").after(rmv);

                $("#mycounttab5").val(counttab5);

                $("#tab5rep" + counttab5).keypress(function(e) {
                    var keyCode = e.which;
                    /*
                    8 - (backspace)
                    32 - (space)
                    48-57 - (0-9)Numbers
                    */
                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
                //  $('input[name="tab5set'+counttab5+'"').keypress(function(e){
                //   var keyCode = e.which;

                //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                //     return false;
                //   }
                // });
                $('input[name="tab5time' + counttab5 + '"').keypress(function(e) {
                    var keyCode = e.which;

                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
            });

        });

        function removetab5(counttab5) {
            // alert(counttab5);

            $('#tab5firsttr' + counttab5).remove();
            $('#tab5rmvbtn' + counttab5).remove();


            // var count3 = counttab5-1;
            // $("#tab5rmvbtn"+count3).show();
            // $("#mycounttab5").val(count3);

        }
    </script>
    <!-- *************************************tab6******************************************* -->
    <script type="text/javascript">
        $(document).ready(function() {
            // **********************************fottab6*********************************
            var counttab6 = 1;
            var countheader6 = 1;

            $(document).on("click", '.addtab6', function() {

                var mycount = $(this).val();
                //     if ($("#mycounttab6").val()!='')
                // {
                //   counttab6= $("#mycounttab6").val();
                //
                // }

                counttab6++;
                var ap = '';
                if ($("#headeryes").val() == 1) {
                    countheader6++;
                    ap += '<tbody id="tbody6' + countheader6 + '" >';
                }
                ap += '<tr id="tab6firsttr' + counttab6 + '" class="tab6item">';
                if ($("#headeryes").val() == 1) {
                    ap += '<td><div class="form-group" > <button type="button" value="' + countheader6 +
                        '" id="add1" class="btn bg-green addtab6" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab6header' +
                        counttab6 + '" class="form-control header"  id="tab6header' + counttab6 +
                        '" placeholder="Enter Header"></div></td>';

                } else {
                    ap += '<td></td><td></td>';
                }
                // $("#headeryes").val(0);
                ap +=
                    ' <td><div class="form-group"><select class="form-control select2"  data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise" data-live-search="true"  name="tab6exercisename' +
                    counttab6 +
                    '"><option value="" disabled="" selected="">Please select</option>         <?php foreach ($exercise as $exercisetab6) {
                        echo '<option value="' . $exercisetab6->exerciseid . '">' . $exercisetab6->exercisename . '</option> ';
                    }
                    ?> <
                    /select></div > <
                    /td><td><div class="form-group"><input type="text" name="tab6time'+counttab6+'" class="form-control"></div >
                    <
                    /td><td><div class="form-group"><input type="text" name="tab6set'+counttab6+'" class="form-control number"></div >
                    <
                    /td><td><div class="form-group"><input id="tab6rep'+counttab6+'"type="text" name="tab6rep'+counttab6+'" class="form-control number exerciseset"></div >
                    <
                    /td> <td><div class="form-group"><input type="text" name="tab6instruction'+counttab6+'" class="form-control"></div >
                    < /td>' +
                '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab6(' +
                counttab6 + ')" ><i class="fa fa-minus"></i></button></td></tr>';

                if ($("#headeryes").val() == 1) {
                    ap += '</tbody>';
                    $('#tbody6' + (countheader6 - 1)).after(ap);
                    $("#headeryes").val(0);
                } else {
                    $('#tbody6' + mycount).append(ap);
                }

                // $('.tab6item:last').after(ap);
                $('.select2').select2()

                // var rmv = '<div id="tab6rmvbtn'+counttab6+'"><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab6('+counttab6+')" ><i class="fa fa-close">Remove</i></button></div>';

                count2 = counttab6 - 1;
                // alert(counttab6);
                $("#tab6rmvbtn" + count2).hide();

                // $(".tab6rmvitem:last").after(rmv);

                $("#mycounttab6").val(counttab6);
                // var count2 = counttab1-1;

                // $("#firstremove"+count2).hide();
                // $(".remove:last").after(rmv);

                // $("#mycount").val(counttab1);
                $("#tab6rep" + counttab6).keypress(function(e) {
                    var keyCode = e.which;
                    /*
                    8 - (backspace)
                    32 - (space)
                    48-57 - (0-9)Numbers
                    */
                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
                //  $('input[name="tab6set'+counttab6+'"').keypress(function(e){
                //   var keyCode = e.which;

                //   if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                //     return false;
                //   }
                // });
                $('input[name="tab6time' + counttab6 + '"').keypress(function(e) {
                    var keyCode = e.which;

                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
            });

        });

        function removetab6(counttab6) {
            // alert(counttab6);

            $('#tab6firsttr' + counttab6).remove();
            $('#tab6rmvbtn' + counttab6).remove();


            // var count3 = counttab6-1;
            // $("#tab6rmvbtn"+count3).show();
            // $("#mycounttab6").val(count3);

        }
    </script>
    <!-- ****************************************tab7**************************** -->
    <script type="text/javascript">
        $(document).ready(function() {
            // **********************************7*********************************
            var counttab7 = 1;
            var countheader7 = 1;

            $(document).on("click", '.addtab7', function() {

                var mycount = $(this).val();
                //     if ($("#mycounttab7").val()!='')
                // {
                //   counttab7= $("#mycounttab7").val();
                //
                // }

                counttab7++;
                var ap = '';
                if ($("#headeryes").val() == 1) {
                    countheader7++;
                    ap += '<tbody id="tbody7' + countheader7 + '" >';
                }
                ap += '<tr id="tab7firsttr' + counttab7 + '" class="tab7item">';
                if ($("#headeryes").val() == 1) {
                    ap += '<td> <div class="form-group" > <button type="button" value="' + counttab7 +
                        '" id="add1" class="btn bg-green addtab7" ><i class="fa fa-plus">Add</i></button> </div></td><td><div class="form-group"><input type="text" name="tab7header' +
                        counttab7 + '" class="form-control header"  id="tab7header' + counttab7 +
                        '" placeholder="Enter Header"></div></td>';

                } else {
                    ap += '<td></td><td></td>';
                }
                // $("#headeryes").val(0);
                ap +=
                    '<td><div class="form-group"><select class="form-control select2" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Exercise Selected" data-header="Select Exercise"  data-live-search="true"  name="tab7exercisename' +
                    counttab7 +
                    '"><option value="" disabled="" selected="">Please select</option>         <?php foreach ($exercise as $exercisetab7) {
                        echo '<option value="' . $exercisetab7->exerciseid . '">' . $exercisetab7->exercisename . '</option> ';
                    }
                    ?> <
                    /select></div > <
                    /td><td><div class="form-group"><input type="text" name="tab7time'+counttab7+'" class="form-control"></div >
                    <
                    /td><td><div class="form-group"><input type="text" name="tab7set'+counttab7+'" class="form-control number "></div >
                    <
                    /td><td><div class="form-group"><input id="tab7rep'+counttab7+'"type="text" name="tab7rep'+counttab7+'" class="form-control  exerciseset"></div >
                    <
                    /td> <td><div class="form-group"><input type="text" name="tab7instruction'+counttab7+'" class="form-control"></div >
                    < /td>' +
                '<td><button type="button" id="remove" class="btn bg-red rmitm" onclick="removetab7(' +
                counttab7 + ')" ><i class="fa fa-minus"></i></button></td></tr>';

                if ($("#headeryes").val() == 1) {
                    ap += '</tbody>';
                    $('#tbody7' + (countheader7 - 1)).after(ap);
                    $("#headeryes").val(0);
                } else {
                    $('#tbody7' + mycount).append(ap);
                }

                // $('.tab7item:last').after(ap);
                $('.select2').select2()

                var rmv = '<div id="tab7rmvbtn' + counttab7 + '"></div>';

                count2 = counttab7 - 1;
                // alert(counttab7);
                $("#tab7rmvbtn" + count2).hide();

                // $(".tab7rmvitem:last").after(rmv);

                $("#mycounttab7").val(counttab7);
                // var count2 = counttab1-1;

                // $("#firstremove"+count2).hide();
                // $(".remove:last").after(rmv);

                // $("#mycount").val(counttab1);
                $("#tab7rep" + counttab7).keypress(function(e) {
                    var keyCode = e.which;
                    /*
                    8 - (backspace)
                    32 - (space)
                    48-57 - (0-9)Numbers
                    */
                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
                // $('input[name="tab7set'+counttab7+'"').keypress(function(e){
                //    var keyCode = e.which;

                //    // if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) {
                //    //   return false;
                //    // }
                //  });
                $('input[name="tab7time' + counttab7 + '"').keypress(function(e) {
                    var keyCode = e.which;

                    if ((keyCode != 8 || keyCode == 32) && (keyCode < 48 || keyCode > 57)) {
                        return false;
                    }
                });
            });

        });

        function removetab7(counttab7) {
            // alert(counttab7);

            $('#tab7firsttr' + counttab7).remove();
            $('#tab7rmvbtn' + counttab7).remove();


            // var count3 = counttab7-1;
            // $("#tab7rmvbtn"+count3).show();
            // $("#mycounttab7").val(count3);

        }
    </script>

    <script type="text/javascript">
        $('#workout').on('keyup', function() {


            var workout = $('#workout').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('checkworkout') }}",
                method: "POST",
                data: {
                    workout: workout,
                    _token: _token
                },
                success: function(result) {
                    if (result == 'unique') {
                        $('#error_username').html('<label class="text-success"></label>');
                        $('#username').removeClass('has-error');
                        $('#firstbtn').attr('disabled', false);
                    } else {
                        // alert("hi1");
                        $('#error_username').html(
                            '<label class="text-danger" style="çolor:red;">WorkOut  is Already Exist</label>'
                            );
                        $('#username').addClass('has-error');
                        $('#firstbtn').attr('disabled', 'disabled');
                    }
                }
            })
        });
    </script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                format: 'MM/DD/YYYY h:mm A'
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
                }
            )

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            })

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            })
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            })
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            })

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })
        })
    </script>
    <script type="text/javascript">
        $('#formtab').on('submit', function() {

            var tab1exercisename1 = $('select[name="tab1exercisename1"]').val();
            if (tab1exercisename1 == null || tab1exercisename1 == '') {
                alert('In Day 1 Please Select Exercise');
                return false;
            }
            var tab2exercisename1 = $('select[name="tab2exercisename1"]').val();
            if (tab2exercisename1 == null || tab2exercisename1 == '') {
                alert('In Day 2 Please Select Exercise');
                return false;
            }
            var tab3exercisename1 = $('select[name="tab3exercisename1"]').val();
            if (tab3exercisename1 == null || tab3exercisename1 == '') {
                alert('In Day 3 Please Select Exercise');
                return false;
            }
            var tab4exercisename1 = $('select[name="tab4exercisename1"]').val();
            if (tab4exercisename1 == null || tab4exercisename1 == '') {
                alert('In Day 4 Please Select Exercise');
                return false;
            }
            var tab5exercisename1 = $('select[name="tab5exercisename1"]').val();
            if (tab5exercisename1 == null || tab5exercisename1 == '') {
                alert('In Day 5 Please Select Exercise');
                return false;
            }
            var tab6exercisename1 = $('select[name="tab6exercisename1"]').val();
            if (tab6exercisename1 == null || tab6exercisename1 == '') {
                alert('In Day 6 Please Select Exercise');
                return false;
            }
            var tab7exercisename1 = $('select[name="tab7exercisename1"]').val();
            if (tab7exercisename1 == null || tab7exercisename1 == '') {
                alert('In Day 7 Please Select Exercise');
                return false;
            }
            if ($('.exercisename')[0]) {
                var exercisename = $('.exercisename').val();

                if (exercisename == null || exercisename == '') {
                    // alert(exercisename);
                    alert('Please Select Exercise');
                    return false;
                }
            }

            var value = [];
            var error = [];
            var day = [];
            // $(document).find('.exerciseset').each(function() {
            //     var a = $(this).val();
            //     var b = $(this).attr("name");

            //     value.push({
            //         RoomName: a,
            //         item: b,
            //     });


            // });
            // var pattern = /[0-9]{2}[*][0-9]{2}[*][0-9]{2}$/;
            // $.each(value, function(key, data) {

            //     if (data.RoomName == 0 || data.RoomName == '') {
            //         // alert(data.RoomName);
            //         return true;
            //     }

            //     if (!pattern.test(data.RoomName)) {
            //         error.push('error' + key);
            //         // alert(JSON.stringify(data.item));
            //         day.push(data.item);
            //         // alert(day);

            //     } else {
            //         // alert('match');
            //     }

            // });
            // // alert(error.length);
            // if (error.length) {

            //     var dayprint = [];
            //     for (i = 0; i < day.length; i++) {
            //         var res = day[i].charAt(3);
            //         if (!dayprint.includes(res)) {
            //             dayprint.push(res);
            //         }

            //     }

            //     alert("Please Enter Proper format set value in Day " + dayprint + " ");
            //     return false;
            // } else {

            // }
            return true;
        });
    </script>

@endsection
