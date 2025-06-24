#!/bin/bash

# configuration
landingpage="landing.txt"
canno="https://inspektorat.saburaijuakab.go.id/files/"
list="title.txt"
desc="desc.txt"
namafolder="folder.txt"



isi_content=$(cat $landingpage)
IFS=$'\n'       # Mengatur delimiter untuk baris baru
for numberone in $(seq $(cat $list | wc -l)); do

    # get nama dir dari folder.txt
    namadirbaru=$(cat $namafolder | sed -n "${numberone}p" | sed "s/ /-/g" | tr -d '\r')
    
    # get textfile dari list title
    textfile=$(cat $list | sed -n "${numberone}p" | tr -d '\r')
    
    # get descriptions dari desc.txt
    descr=$(cat $desc | sed -n "${numberone}p" | tr -d '\r')
    escaped_url=$(echo "$canno" | sed 's/\//\\\//g')
    path="$(pwd)/$namadirbaru"

    # Membuat direktori jika belum ada
    if [ ! -d "$path" ]; then
        mkdir -p "$path"
    fi

    # Menyusun path untuk file index.php
    file_path="$path/index.php"

    sed "s/judul/${textfile}/g;s/ulwa/${namadirbaru} ${descr}/g;s/localhost/${escaped_url}${namadirbaru}\//g" $landingpage > "$file_path"
    echo "Direktori dan file index.php untuk $namadirbaru telah berhasil dibuat."
done

setelah selesai semua command "bash main.sh"
