
<div class="wrapper row-offcanvas row-offcanvas-left">
<!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                        
                    <?php
                        //include "function-menu.php";
                    ?>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                     <!-- in_array('1', $_SESSION['access_menu']) $_SESSION['role'] == 'admin' -->
                    <?php if( in_array('userreg', $_SESSION['menu_group']) ){ ?> <!-- or $_SESSION['role'] == 'proc' -->

                        <!-- MENU FOR REGISTERING VENDOR-->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-group"></i>
                                <span>Registering User</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>

                            <ul class="treeview-menu">
                                
                                <?php if( in_array('mnumaster', $_SESSION['access_group'])  ){ // OR $_SESSION['role'] == 'admin'?>  
                                    <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=mnumaster<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Menu List</a>
                                    </li>
                                <?php } //menu 2 ?>

                                <?php if( in_array('mnugroup', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=mnugroup<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Menu Group</a>
                                    </li>
                                <?php } //menu 2 ?>
                                
                               
                                <?php if( in_array('accgrmaster', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=accgrmaster<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Access Group</a>
                                    </li>
                                <?php } //menu 3 ?>   
                                
                                <!--
                                <?php if( in_array('accgrmaster', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=acccodemaster<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Access Code</a>
                                    </li>
                                <?php } //menu 3 ?> 
                                -->

                                <?php if( in_array('emailgrp', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=emailgrp<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Email Group</a>
                                    </li>
                                <?php } //menu 3 ?> 

                                <?php if( in_array('emailgrlist', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=emailgrlist<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Email List Group</a>
                                    </li>
                                <?php } //menu 3 ?> 

                                <?php if( in_array('umaster', $_SESSION['access_group'])  ){ ?> 
                                    <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=umaster<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> User Master</a>
                                    </li>
                                <?php } //menu 1 ?> 

                                <?php if( in_array('vmaster', $_SESSION['access_group'])  ){ ?> 
                                    <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=vmaster<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Vendor Master</a>
                                    </li>
                                <?php } //menu 6 ?> 
                                
                                <?php if( in_array('usrlog', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=usrlog<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> User Log Record</a>
                                    </li>
                                <?php } //menu 4 ?>

                                <?php if( in_array('srvlog', $_SESSION['access_group'])  ){ ?>     
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=srvlog<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Service Log Record</a>
                                    </li>
                                <?php } //menu 5 ?>
                                
                                <?php if( in_array('pdaccs', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=pdaccs<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> User PDA Access</a>
                                    </li>
                                <?php } //menu 7 ?>

                                <?php if( in_array('numrange', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=numrange<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Number Range</a>
                                    </li>
                                <?php } //menu 3 ?> 

                            </ul>
                        </li>                      

                       <?php } //menu group 1 ?>

                        <?php //if($_SESSION['role']=='admin' or $_SESSION['role']=='vendor' or $_SESSION['role']=='proc'  or $_SESSION['role']=='qa' or $_SESSION['role']=='eng'){ ?>
                        
                        <?php if( in_array('projectmgt', $_SESSION['menu_group']) ){ ?>
                        
                        <!-- MENU FOR DOCUMENT PROJECT -->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa  fa-file"></i>
                                <span>Project Management</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <?php if( in_array('projmaster', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=projmaster<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Project Master</a>
                                    </li>
                                <?php } ?>
                                
                                <?php if( in_array('prodmaster', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=prodmaster<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Product Master</a>
                                    </li>
                                <?php } ?>

                                <?php if( in_array('partmaster', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=partmaster<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Part Master</a>
                                    </li>
                                <?php } ?>

                                <?php if( in_array('docmaster', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=docmaster<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Document Master</a>
                                    </li>
                                <?php } ?>
                                
                                <?php if( in_array('listcheckmaster', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=listcheckmaster<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> List Check Master</a>
                                    </li>
                                <?php } ?>
                                
                                <?php if( in_array('uplddraw', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=uplddraw<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Upload Project Doc</a>
                                    </li>
                                <?php } ?>
                                
                                <?php if( in_array('vuplddraw', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=vuplddraw<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Check Eng Doc</a>
                                    </li>
                                <?php } ?>

                                <?php if( in_array('vassign', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=vassign<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Assign Vendor</a>
                                    </li>
                                <?php } ?>
                                
                                <?php if( in_array('vuplddrawvdr', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=vuplddrawvdr<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> View Doc (Vendor)</a>
                                    </li>
                                <?php } ?>

                                <?php if( in_array('uplddoceng', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=uplddoceng<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Upload Required Doc</a>
                                    </li>
                                <?php } ?>

                                <?php if( in_array('vendprojmonitor', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=vendprojmonitor<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Vendor Monitoring</a>
                                    </li>
                                <?php } ?>
                                
                                <?php if( in_array('vupldeng', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=vupldeng<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Check Vendor Doc</a>
                                    </li>
                                <?php } ?>
                                
                                <?php if( in_array('monitoring', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=monitoring<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Dashboard Project</a>
                                    </li>
                                <?php } ?>
                                
                                <?php if( in_array('flmstr', $_SESSION['access_group']) ){ ?> 
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=flmstr<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> File Master</a>
                                    </li>
                                <?php } ?>

                            </ul>
                        </li>
                        <?php }  //menu group 2  ?>

                        <?php //if($_SESSION['role']=='admin' or $_SESSION['role']=='proc' or $_SESSION['role']=='vendor' ) { ?>

                        <?php if( in_array('purchproc', $_SESSION['menu_group']) ){ ?>    

                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Purchasing Process</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>
                                <ul class="treeview-menu">

                                    <?php //if($_SESSION['role']=='admin' or $_SESSION['role']=='proc'){ ?>

                                    <?php if( in_array('uplaprvpo', $_SESSION['access_group']) ){ ?> 
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=uplaprvpo<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> Upload Approved PO</a>
                                        </li>
                                    <?php } ?>
                                    
                                    <?php if( in_array('dlistpo', $_SESSION['access_group']) ){ ?> 
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=dlistpo<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> List PO</a>
                                        </li>
                                    <?php } ?>

                                        <!--
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=uplpofile<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> Upload PO File List</a>
                                        </li>
                                        -->

                                    <?php //} ?>

                                    <?php //if($_SESSION['role']=='admin' or $_SESSION['role']=='proc' or $_SESSION['role']=='vendor' ) { ?>
                                    <?php if( in_array('dwldpo', $_SESSION['access_group']) ){ ?> 
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=dwldpo<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> Download PO</a>
                                        </li>
                                    <?php } ?>
                                    <?php //} ?>

                                </ul>
                            </li>

                        <?php } ?>

                        <!--
                        <li class="treeview">
                            <a href="#">
                                <i class="fa  fa-truck"></i>
                                <span>Delivery Schedule</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=schmastersct<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> View Delivery Schedule</a>
                                </li>

                                <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=gdrcpt<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Upload AR/SR</a>
                                </li>
                                <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=schplanact<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> AR/SR</a>
                                </li>
                                <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=rawstckupl<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Vendor Raw Mat Stock</a>
                                </li>
                                <li>
                                    <a href="home.php?<?php echo token(); ?>mnu=matstckupl<?php echo token2(); ?>">
                                        <i class="fa fa-dot-circle-o" ></i> Vendor F/G Stock</a>
                                </li>
                            </ul>
                        </li>
                        -->

                        <?php //if($_SESSION['role']=='admin' or $_SESSION['role']=='proc'){ ?>
                        
                        <?php if( in_array('deliverysch', $_SESSION['menu_group']) ){ ?>  

                            <li class="treeview">
                                <a href="#">    
                                    <i class="fa  fa-truck"></i>
                                    <span>Delivery Schedule</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>

                                <ul class="treeview-menu">

                                    <!--
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=rawstckupl<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Vendor Raw Mat Stock</a>
                                    </li>
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=matstckupl<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Vendor F/G Stock</a>
                                    </li>
                                    -->
                                    
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=dwldmfo<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Download Mf Order </a>
                                    </li>

                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=dwldspo<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Download Spc Order </a>
                                    </li>

                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=dashsch<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Monitoring Delivery </a>
                                    </li>
                                </ul>
                            </li>

                        <?php } ?>

                        <?php if( in_array('dociso', $_SESSION['menu_group']) ){ ?>  

                            <li class="treeview">
                                <a href="#">    
                                    <i class="fa  fa-files-o"></i>
                                    <span>Doc ISO Manage</span>
                                    <i class="fa fa-angle-left pull-right"></i>
                                </a>

                                <ul class="treeview-menu">
                                    
                                    
                                    
                                    <?php if( in_array('mstcert', $_SESSION['access_group']) ){ ?> 
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=mstcert<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> <strike>Master Cert Type</strike> </a>
                                        </li>
                                    <?php } ?>
                                    
                                    <?php if( in_array('mstiso', $_SESSION['access_group']) ){ ?> 
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=mstiso<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> <strike>Master ISO Type </strike> </a>
                                        </li>
                                    <?php } ?>
                                    
                                    <?php if( in_array('mstnotif', $_SESSION['access_group']) ){ ?>
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=mstnotif<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> Master Notify </a>
                                        </li>
                                    <?php } ?>
                                    
                                    <?php if( in_array('regiso', $_SESSION['access_group']) ){ ?>
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=regiso<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> Register ISO Doc</a>
                                        </li>
                                    <?php } ?>
                                    
                                    <?php if( in_array('isoreport', $_SESSION['access_group']) ){ ?>
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=isoreport<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> Report ISO Doc</a>
                                        </li>
                                    <?php } ?>

                                    <?php if( in_array('dashiso', $_SESSION['access_group']) ){ ?> 
                                        <li>
                                            <a href="home.php?<?php echo token(); ?>mnu=dashiso<?php echo token2(); ?>">
                                                <i class="fa fa-dot-circle-o" ></i> Dashboard ISO Doc </a>
                                        </li>
                                    <?php } ?>

                                    <!--
                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=isorelease<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Doc ISO Approve/Reject</a>
                                    </li>

                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=isorenewal<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Doc ISO Renewal</a>
                                    </li>

                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=isoreview<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Doc ISO Review</a>
                                    </li>

                                    <li>
                                        <a href="home.php?<?php echo token(); ?>mnu=isochange<?php echo token2(); ?>">
                                            <i class="fa fa-dot-circle-o" ></i> Doc ISO Change</a>
                                    </li>
                                    -->

                                </ul>
                            </li>
                            <?php } ?>

                    </ul>

                </section>
                <!-- /.sidebar -->
            </aside>
    