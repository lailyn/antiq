<div class="col-lg-4">
  <h4>
    <form action="blog/cari" method="get">
      <div class="input-group mb-3">
        <input name="cari" type="text" class="form-control" placeholder="Kata Kunci" aria-label="Recipient's username" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
      </div>
    </form>
  </h4>
  <h4>Kategori</h4><br>
  
    <div class="row">      
      <div class="col-lg-12">
        <ul>
        <?php 
        $no=1;
        $sql = $this->db->query("SELECT md_artikel_kategori.id_artikel_kategori, md_artikel_kategori.kategori,count(md_artikel.id_artikel) AS jum FROM md_artikel 
          INNER JOIN md_artikel_kategori ON md_artikel.id_artikel_kategori = md_artikel_kategori.id_artikel_kategori
          INNER JOIN md_user ON md_artikel.created_by = md_user.id_user
          WHERE md_artikel.status = 'publish' GROUP by md_artikel_kategori.id_artikel_kategori 
          HAVING jum > 0 
          ORDER BY md_artikel_kategori.kategori ASC LIMIT 0,10");
        foreach ($sql->result() as $isi) {                      
          echo "<li><a href='blog/kategori/$isi->id_artikel_kategori'>$isi->kategori <span>($isi->jum)</span></a></li>";
        }
        ?>                  

      </ul>
      </div>
    </div>
    <hr>
  

  <h4>Artikel Terpopuler</h4><br>
  <?php 
  $sql = $this->db->query("SELECT * FROM md_artikel WHERE status = 'publish' ORDER BY baca DESC LIMIT 0,7");
  foreach ($sql->result() as $isi) {            
    if(!isset($isi->gambar1) AND $isi->gambar1==""){
      $foto = "alt-tag.png";
    }else{
      $foto = $isi->gambar1;
    }
  ?>
    <div class="row">
      <div class="col-lg-5">
        <a href="blog/detail/<?php echo $isi->permalink ?>"><img src="assets/art1kel/<?php echo $foto ?>" width="100%"></a>
      </div>
      <div class="col-lg-7">
        <a href="blog/detail/<?php echo $isi->permalink ?>"><?php echo $isi->judul ?></a>
      </div>
    </div>
    <hr>
  <?php } ?>
</div>