
<div class="container">
    <div class="card">
        
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5">
                    <?= $this->session->flashdata('message'); ?>
                    <div class="p-4">
                        <form method="POST" action="<?= base_url('admin/add_mole'); ?>" enctype="multipart/form-data">

                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control">
                            </div>
                            <?= form_error('nama', '<small class="text-danger ml-3">', '</small>') ?>


                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" class="form-control">
                            </div>
                            <?= form_error('jumlah', '<small class="text-danger ml-3">', '</small>') ?>


                            <div class="input-group input-group-outline mb-4">
                                <label class="form-label">Harga</label>
                                <input type="number" name="harga" class="form-control">
                            </div>
                            <?= form_error('harga', '<small class="text-danger ml-3">', '</small>') ?>


                            <div class="input-group input-group-static mb-4">
                            <input type="file" name="file">
                            </div>
                            <?= form_error('file', '<small class="text-danger ml-3">', '</small>') ?>


                            <button type="submit" class="btn btn-success">Tambah</button>

                        </form>
                    </div>
                </div>
                <div class="col-lg-5">

                </div>
            </div>
        </div>
    </div>
</div>

