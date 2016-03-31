<?php
/**
 * @var $this \view\StaffSearchView
 */
?>
<div class="row">
    <div class="col-md-3 col-sm-4">
        <div class="panel panel-default">

            <div class="panel-body">
                <input style="" class="form-control staff-search" type="text" placeholder="Suche...">

                <table id="example" class="table compact" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>

                    <tfoot>

                    </tfoot>

                </table>


            </div>

        </div>



    </div>

    <div id="detail-view" class="col-md-9 col-sm-8 hidden-xs">
        <div class="panel panel-default">

            <div class="panel-body">

                <?=$this->getStaffDetail()?>

            </div>

            </div>
        </div>


</div>


<div class="modal-container">
    <!-- Modal fullscreen -->
    <div class="modal modal-fullscreen fade fade-in-left" id="modal-fullscreen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
                    <a class="" style="text-decoration: none;" data-dismiss="modal"><h4 class="modal-title click-cursor" id="myModalLabel"><span class="fa fa-chevron-left"></span> Alle Mitarbeiter</h4></a>
                </div>

                    <div class="modal-body" >



                    </div>
                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    </div>


            </div>
        </div>
    </div>

</div>
