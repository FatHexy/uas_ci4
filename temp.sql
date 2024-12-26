CREATE TABLE katalog (
  ISBN VARCHAR(13) NOT NULL AUTO_INCREMENT,
  Judul VARCHAR(255) NOT NULL,
  Penulis VARCHAR(255) NULL,
  Penerbit VARCHAR(255) NULL,
  Tahun_Terbit VARCHAR(4) NULL,
  Jumlah_Eksemplar INTEGER UNSIGNED NOT NULL,
  Jumlah_Tersedia INTEGER UNSIGNED NULL,
  PRIMARY KEY(ISBN)
);

CREATE TABLE anggota  (
  ID_Anggota VARCHAR(6) NOT NULL AUTO_INCREMENT,
  Nama VARCHAR(255) NOT NULL,
  Alamat TEXT NULL,
  No_Telepon VARCHAR NOT NULL,
  Email VARCHAR NULL,
  PRIMARY KEY(ID_Anggota),
  UNIQUE INDEX unique(Email, No_Telepon)
);

CREATE TABLE admin (
  ID_Admin VARCHAR(10) NOT NULL AUTO_INCREMENT,
  Username VARCHAR(50) NOT NULL,
  Password_2 VARCHAR(255) NOT NULL,
  Nama VARCHAR(255) NULL,
  Email VARCHAR(255) NULL,
  PRIMARY KEY(ID_Admin),
  INDEX unique(Username, Email)
);


CREATE TABLE transaksi (
  ID_Transaksi VARCHAR(15) NOT NULL AUTO_INCREMENT,
  anggota _ID_Anggota VARCHAR(6) NOT NULL,
  Tanggal_Pinjam DATETIME NULL,
  Tanggal_Kembali_Rencana DATE NULL,
  Tanggal_Kembali_Realisasi DATETIME NULL,
  Denda BIGINT NULL,
  Status_2 ENUM('active', 'done') NULL,
  PRIMARY KEY(ID_Transaksi),
  INDEX transaksi_FKIndex2(anggota _ID_Anggota),
  FOREIGN KEY(anggota _ID_Anggota)
    REFERENCES anggota (ID_Anggota)
      ON DELETE CASCADE
      ON UPDATE CASCADE
);

CREATE TABLE buku (
  Kode_Buku INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  katalog_ISBN VARCHAR(13) NOT NULL,
  Tersedia INTEGER(1) UNSIGNED NULL,
  PRIMARY KEY(Kode_Buku),
  INDEX buku_FKIndex1(katalog_ISBN),
  FOREIGN KEY(katalog_ISBN)
    REFERENCES katalog(ISBN)
      ON DELETE CASCADE
      ON UPDATE CASCADE
);

CREATE TABLE log_transaksi (
  ID_Log INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  admin_ID_Admin VARCHAR(10) NOT NULL,
  transaksi_ID_Transaksi VARCHAR(15) NOT NULL,
  Deskripsi TEXT NULL,
  Waktu DATETIME NULL,
  PRIMARY KEY(ID_Log),
  INDEX log_transaksi_FKIndex1(transaksi_ID_Transaksi),
  INDEX log_transaksi_FKIndex2(admin_ID_Admin),
  FOREIGN KEY(transaksi_ID_Transaksi)
    REFERENCES transaksi(ID_Transaksi)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(admin_ID_Admin)
    REFERENCES admin(ID_Admin)
      ON DELETE CASCADE
      ON UPDATE CASCADE
);

CREATE TABLE detail_transaksi (
  buku_Kode_Buku INTEGER UNSIGNED NOT NULL,
  transaksi_ID_Transaksi VARCHAR(15) NOT NULL,
  INDEX detail_transaksi_FKIndex2(transaksi_ID_Transaksi),
  INDEX detail_transaksi_FKIndex2(buku_Kode_Buku),
  FOREIGN KEY(transaksi_ID_Transaksi)
    REFERENCES transaksi(ID_Transaksi)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(buku_Kode_Buku)
    REFERENCES buku(Kode_Buku)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

