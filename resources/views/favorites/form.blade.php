<div class="modal fade" id="modal-form" tabindex="1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form  id="form-item" method="post" class="form-horizontal" data-toggle="validator" enctype="multipart/form-data" >
                {{ csrf_field() }} {{ method_field('POST') }}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"></h3>
                </div>


                <div class="modal-body">
                    <input type="hidden" id="id" name="id">


                    <div class="box-body">
                        <div class="form-group">
                            <label >Favorite Mingguan</label>
                            {!! Form::select('minggu', ['' => 'Pilih Minggu','Minggu ke 1' => 'Minggu ke 1', 'Minggu ke 2' => 'Minggu ke 2','Minggu ke 3' => 'Minggu ke 3', 'Minggu ke 4' => 'Minggu ke 4', 'Tidak Ada' => 'Tidak Ada'  ],' '); !!}
                            <span class="help-block with-errors"></span>
                        </div>

                        <br>

                        <div class="form-group">
                            <label >Favorite Bulanan</label>
                            {!! Form::select('bulan', ['' => 'Pilih Bulan','January' => 'January', 'February' => 'February','March' => 'March', 'April' => 'April', 'May' => 'May', 'June' => 'June', 'July' => 'July',
                                'August' => 'August', 'September' => 'September', 'October' =>'October', 'November' => 'November', 'December' => 'December','Tidak Ada' => 'Tidak Ada'],' '); !!}
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label >Category</label>
                        {!! Form::select('product_id', $product, null, ['class' => 'form-control select', 'placeholder' => '-- Choose Product --', 'id' => 'product_id', 'required']) !!}
                        <span class="help-block with-errors"></span>
                    </div>

                    <div class="form-group">
                        <label >Category</label>
                        {!! Form::select('category_id', $category, null, ['class' => 'form-control select', 'placeholder' => '-- Choose Category --', 'id' => 'category_id', 'required']) !!}
                        <span class="help-block with-errors"></span>
                    </div>
                    <!-- /.box-body -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
