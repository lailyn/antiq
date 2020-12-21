<div class="col-lg-4">  
  <h4>Layanan Lain</h4><br>
  <?php 
  $sql = $this->db->query("SELECT * FROM md_layanan ORDER BY layanan ASC");
  foreach ($sql->result() as $isi) {                
  ?>
    <div class="row">      
      <div class="col-lg-12">
        <ul>
        <?php 
        $no=1;        
        echo "<li><a href='layanan/detail/$isi->id_layanan'>$isi->layanan</a></li>";      
        ?>                  
      </ul>
      </div>
    </div>    
  <?php } ?> 
</div>