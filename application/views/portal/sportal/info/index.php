
<body>
<!--sidebar-menu-->
<div id="sidebar">
  <ul>
    <li><a href="<?=site_url('/sportal');?>"><i class="icon icon-home"></i> <span>HOME</span></a> </li>
    <li class="active"><a href="<?=site_url('/info');?>"><i class="icon icon-user"></i> <span>MY INFO</span></a> </li>
    <li><a href="<?=site_url('/grades');?>"><i class="icon icon-edit"></i> <span>MY GRADES</span></a> </li>
    <li><a href="<?=site_url('/schedules');?>"><i class="icon icon-calendar"></i> <span>MY SCHEDULES</span></a> </li>
    <li><a href="<?=site_url('/curriculum');?>"><i class="icon icon-list-alt"></i> <span>COURSE CURRICULUM</span></a> </li>
    <li><a href="<?=site_url('/forum2');?>"><i class="icon icon-comments-alt"></i> <span>UNIVERSITY FORUM</span></a></li>
  </ul>
</div>
<!--sidebar-menu-->

<!--main-container-part-->
<div id="content">
<!--breadcrumbs-->
  <div id="content-header">
    <div id="breadcrumb">
    <a href="<?=site_url('/sportal');?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
    <a href="<?=site_url('/info');?>" title="Go to Home" class="tip-bottom"><i class="icon-user"></i> My Info</a>
    </div>
  </div>
<!--End-breadcrumbs-->

<!--Content-->
  <div class="container-fluid">
  <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
            <h5><B>STUDENT INFORMATION</B></h5>
          </div>
          <div class="widget-content nopadding">
<table class="table table-bordered table-striped" style="font-size: 13px;">
<tbody>
<tr>
<td>Student Name:</td>
<td><?=$this->session->last_name.", ".$this->session->first_name?></td>
</tr>
<tr>
<td>Student ID:</td>
<td><?=$this->session->id?>
</td>
</tr>
<tr>
<td>Course:</td>
<td><?=$this->session->course?></td>
</tr>
<tr>
<td>Department:</td>
<td><?=$this->session->college_dept?></td>
</tr>
<tr>
<td>Current Year:</td>
<td><?=$this->session->year?></td>
</tr>
</tbody>
</table>

    </div>
  </div>
  </div>
  </div>
  </div>
  <!--End of Content-->

</div>

    






