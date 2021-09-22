<?php

namespace App\Http\Controllers\Tanitim;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FonksiyonlarController;
use App\GenelFonksiyonlar;
use Illuminate\Http\Request;
use Cookie;
use App\Models\{Urun, UrunFiyat, UrunAnaliz, KategoriAnaliz, UrunKategori, UrunKategoriAlt, Ulke,
	UlkeKod, Kategori, KategoriAlt, KategoriDil, KategoriAltDil,
	Ziyaretci, Marka, Etiket, Filtre, FiltreKategori, FiltreKategoriAlt, UrunEtiket, Yorum, UrunHaberVer};

	class ShopController extends Controller
	{
		public function super_unique($array,$key){ 
			$temp_array = [];
			foreach ($array as &$v) {
				if (!isset($temp_array[$v[$key]]))
					$temp_array[$v[$key]] =& $v;
			}
			$array = array_values($temp_array);
			return $array;

		}

		public function ulkeIdBul(){
			$ipUlke = GenelFonksiyonlar::getIp();
			$ip = $ipUlke['ip'];
			$ulkeKod = $ipUlke['ulkeKod'];
			
			$ulkeKod = UlkeKod::where('kod', $ulkeKod)->first();
			$ulke = Ulke::where('ulke_kod_id', $ulkeKod->id)->first();

			if(isset($ulke->id)){
				return $ulke->id;
			}else{
				return 0;
			}
		}

		public function ziyaretciDilBul(){
			$ziyaretciId = Cookie::get('ziyaretci_id');
			$ziyaretci = Ziyaretci::find($ziyaretciId);

			return $ziyaretci->dil_id;
		}

		public function shop(){
			$ulkeId = $this->ulkeIdBul();

			$urunler = Urun::join('urun_fiyat', 'urun.id', '=', 'urun_fiyat.urun_id')
			->where('urun_fiyat.ulke_id', $ulkeId)
			->orderBy('urun.created_at', 'DESC')
			->paginate(16);

			return view('tanitim.shop.shop', compact('urunler'));
		}

		public function kategori($kategori){
			$ulkeId = $this->ulkeIdBul();
			$gelenMarka = [];
			$gelenEtiket = []; 

			$data = request()->all(); 
			if(isset($data['filterPrice'])){
				$filtreFiyat = $data['filterPrice'];
			}else{
				$filtreFiyat = "";
			} 

			$kategoriBul = Kategori::whereSlug($kategori)->firstOrFail();

			$analiz = KategoriAnaliz::where('kategori_id', $kategoriBul->id)->first();
			$tiklama = $analiz->tiklama + 1; 

			KategoriAnaliz::where('kategori_id', $kategoriBul->id)->update([
				'tiklama'=>$tiklama
			]);
			$kategoriAltlar = Kategori::where('ust_id', $kategoriBul->id)
			->where('durum', 1) 
			->orderBy('sira', 'asc')
			->get(); 
			$random = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
			->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->select('urun.*','kategori.durum', 'marka.durum') 
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null)
			->where('marka.durum', 1)
			->where('marka.deleted_at', '=', null)
			->where('urun_kategori.deleted_at', '=', null)
			->where('urun.durum', 1)
			->distinct('urun_kategori')
			->inRandomOrder()
			->take(16)
			->get();

			if($filtreFiyat == ""){
				$urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum')
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null)  
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->distinct('urun_kategori.id')
				->paginate(16);

			}

			if($filtreFiyat == "priceDesc"){ 
				$urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->orderBy('urun_fiyat.fiyat', 'desc')
				->distinct('urun_kategori.id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')
				->paginate(16);
			}

			if($filtreFiyat == "priceAsc"){
				$urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->orderBy('urun_fiyat.fiyat', 'asc')
				->distinct('urun_kategori.id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')
				->paginate(16);

			}

			//$markalar = Marka::where('durum', 1)->orderBy('ad', 'asc')->get();
			$markalar = UrunKategori::where('kategori_id', $kategoriBul->id)
			->join('urun', 'urun_kategori.urun_id', '=','urun.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->where('marka.durum',1)
			->where('marka.deleted_at', null) 
			->where('urun.deleted_at', null) 
			->where('urun.durum',1)
			->where('urun_kategori.deleted_at',null)
			->select('marka.*',) 
			->distinct("urun.marka")
			->orderBy('marka.ad', 'asc')
			->get();


			$filtreler = Filtre::join('filtre_kategori', 'filtre.id', '=', 'filtre_kategori.filtre_id')
			->where('filtre_kategori.kategori_id', $kategoriBul->id)
			->where('filtre_kategori.deleted_at', '=', null) 
			->where('filtre.deleted_at', '=', null) 
			->where('durum', 1)
			->get();

			$kategori = $kategoriBul;

			$sonucSayi = count($urunler); 
			$fiyat = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
			->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null)
			->where('marka.durum', 1)
			->where('marka.deleted_at', '=', null)
			->where('urun_kategori.kategori_id', $kategoriBul->id)
			->where('urun_fiyat.deleted_at', '=', null)
			->where('urun_fiyat.ulke_id', $ulkeId)
			->where('urun_kategori.deleted_at', '=', null) 
			->where('urun.deleted_at', '=', null) 
			->where('urun.durum', 1)
			->orderBy('urun_fiyat.fiyat', 'asc')
			->distinct('urun_kategori.id')
			->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')
			->get(); 
			$gelenBaslangicFiyat = null;
			$gelenBitisFiyat = $fiyat->max('fiyat'); 
			return view('tanitim.shop.kategori', compact('urunler','gelenMarka', 'gelenEtiket', 'kategoriAltlar', 'kategori', 'random', 'markalar','filtreler' , 'filtreFiyat', 'gelenBaslangicFiyat', 'gelenBitisFiyat'));
		}

		public function kategoriFilter($kategori){
			$ulkeId = $this->ulkeIdBul();
			$data = request()->all(); 
			$urun = array();
			$gelenMarka = [];
			$gelenEtiket = [];
			$gelenBaslangicFiyat = "0";
			$gelenBitisFiyat = "100000";
			if (isset($data['price_start'])) {
				$gelenBaslangicFiyat = $data['price_start']; 
			} 
			if (isset($data['price_finish'])) { 
				$gelenBitisFiyat = $data['price_finish']; 
			} 

			$filtreFiyat = "";
			$kategoriBul = Kategori::whereSlug($kategori)->firstOrFail();

			$kategoriAltlar = Kategori::where('ust_id', $kategoriBul->id)
			->where('durum', 1) 
			->orderBy('sira', 'asc')
			->get(); 

			$random = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
			->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->select('urun.*','kategori.durum', 'marka.durum') 
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null)
			->where('marka.durum', 1)
			->where('marka.deleted_at', '=', null)
			->where('urun_kategori.deleted_at', '=', null)
			->where('urun.durum', 1)
			->distinct('urun_kategori')
			->inRandomOrder()
			->take(9)
			->get();

			if(isset($data['markalar']) and !isset($data['etiketler'])){

				$urun = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')		
				->where('kategori.durum', 1)
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->WhereIn('marka', $data['markalar'])
				->where('urun_fiyat.fiyat', '>', $gelenBaslangicFiyat)
				->where('urun_fiyat.fiyat', '<', $gelenBitisFiyat)
				->orderBy('urun_fiyat.fiyat','asc')
				->distinct('urun_kategori.id')
				->paginate(16);
				$gelenMarka = $data['markalar'];  
			}

			if(!isset($data['markalar']) and isset($data['etiketler'])){

				$urun = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_etiket.etiket_id', 'urun_fiyat.fiyat')		
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun_etiket.deleted_at', '=', null)
				->where('urun.durum', 1)
				->WhereIn('urun_etiket.etiket_id', $data['etiketler'])
				->where('urun_fiyat.fiyat', '>=', $gelenBaslangicFiyat)
				->where('urun_fiyat.fiyat', '<=', $gelenBitisFiyat)
				->orderBy('urun_fiyat.fiyat','asc')
				->distinct('urun_kategori.id')
				->paginate(16); 
				$gelenEtiket = $data['etiketler'];  
			}

			if(isset($data['markalar']) and isset($data['etiketler'])){
				$urun = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_etiket.etiket_id','urun_fiyat.fiyat')	
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun_etiket.deleted_at', '=', null)
				->where('urun.durum', 1) 
				->WhereIn('urun_etiket.etiket_id', $data['etiketler'])
				->WhereIn('marka', $data['markalar'])
				->where('urun_fiyat.fiyat', '>=', $gelenBaslangicFiyat)
				->where('urun_fiyat.fiyat', '<=', $gelenBitisFiyat)
				->orderBy('urun_fiyat.fiyat','asc')
				->distinct('urun_kategori.id')
				->paginate(16);  
				$gelenMarka = $data['markalar'];
				$gelenEtiket = $data['etiketler']; 
			}

			if(!isset($data['markalar']) and !isset($data['etiketler'])){
				$urun = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->where('urun_fiyat.fiyat', '>=', $gelenBaslangicFiyat)
				->where('urun_fiyat.fiyat', '<=', $gelenBitisFiyat)
				->orderBy('urun_fiyat.fiyat','asc')
				->distinct('urun_kategori.id')
				->paginate(16);
			} 

			//$urunler = $this->super_unique($urun,'urun_id');

			$urunler = $urun;
			$markalar = UrunKategori::where('kategori_id', $kategoriBul->id)
			->join('urun', 'urun_kategori.urun_id', '=','urun.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->where('marka.durum',1)
			->where('marka.deleted_at', null) 
			->where('urun.deleted_at', null) 
			->where('urun.durum',1)
			->where('urun_kategori.deleted_at',null)
			->select('marka.*',) 
			->distinct("urun.marka")
			->orderBy('marka.ad', 'asc')
			->get();

			$filtreler = Filtre::join('filtre_kategori', 'filtre.id', '=', 'filtre_kategori.filtre_id')
			->where('filtre_kategori.kategori_id', $kategoriBul->id)
			->where('filtre_kategori.deleted_at', '=', null) 
			->where('filtre.deleted_at', '=', null) 
			->where('durum', 1)
			->get(); 
			$kategori = $kategoriBul;

			return view('tanitim.shop.kategori', compact('urunler', 'gelenMarka', 'gelenEtiket', 'kategoriAltlar', 'kategori', 'random', 'markalar','filtreler', 'gelenBaslangicFiyat', 'gelenBitisFiyat' ,'filtreFiyat'));
		}

		public function kategoriAlt($kategori, $kategoriAlt){
			$ulkeId = $this->ulkeIdBul();
			$data = request()->all(); 
			$gelenMarka = [];
			$gelenEtiket = []; 
			if(isset($data['filterPrice'])){
				$filtreFiyat = $data['filterPrice'];
			}else{
				$filtreFiyat = "";
			} 

			$ustKategori = Kategori::whereSlug($kategori)->firstOrFail();
			$kategoriBul = Kategori::whereSlug($kategoriAlt)->firstOrFail();

			$analiz = KategoriAnaliz::where('kategori_id', $kategoriBul->id)->first();
			$tiklama = $analiz->tiklama + 1; 

			KategoriAnaliz::where('kategori_id', $kategoriBul->id)->update([
				'tiklama'=>$tiklama
			]);
			$kategoriAltlar = Kategori::where('ust_id', $kategoriBul->id)
			->where('durum', 1)
			->orderBy('sira', 'asc')
			->get();

			$random = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
			->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->select('urun.*','kategori.durum', 'marka.durum') 
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null)
			->where('marka.durum', 1)
			->where('marka.deleted_at', '=', null)
			->where('urun_kategori.deleted_at', '=', null)
			->where('urun.durum', 1)
			->inRandomOrder()
			->distinct('urun_kategori')
			->take(16)
			->get();

			$kategoriAlt = Kategori::where('slug', $kategoriAlt)->first();

			if($filtreFiyat == ""){
				$urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum')
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->distinct('urun_kategori.id')
				->paginate(16);
			}

			if($filtreFiyat == "priceDesc"){ 
				$urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->orderBy('urun_fiyat.fiyat', 'desc')
				->distinct('urun_kategori.id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')
				->paginate(16);
			}

			if($filtreFiyat == "priceAsc"){
				$urunler = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->orderBy('urun_fiyat.fiyat', 'asc')
				->distinct('urun_kategori.id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')
				->paginate(16);
			}
			$markalar = UrunKategori::where('kategori_id', $kategoriBul->id)
			->join('urun', 'urun_kategori.urun_id', '=','urun.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->where('marka.durum',1)
			->where('marka.deleted_at', null) 
			->where('urun.deleted_at', null) 
			->where('urun.durum',1)
			->where('urun_kategori.deleted_at',null)
			->select('marka.*',) 
			->distinct("urun.marka")
			->orderBy('marka.ad', 'asc')
			->get();

			$filtreler = Filtre::join('filtre_kategori', 'filtre.id', '=', 'filtre_kategori.filtre_id')
			->where('filtre_kategori.kategori_id', $kategoriBul->id)
			->where('filtre_kategori.deleted_at', '=', null) 
			->where('filtre.deleted_at', '=', null) 
			->where('durum', 1)
			->get();

			$fiyat = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
			->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null)
			->where('marka.durum', 1)
			->where('marka.deleted_at', '=', null)
			->where('urun_kategori.kategori_id', $kategoriBul->id)
			->where('urun_fiyat.deleted_at', '=', null)
			->where('urun_fiyat.ulke_id', $ulkeId)
			->where('urun_kategori.deleted_at', '=', null) 
			->where('urun.deleted_at', '=', null) 
			->where('urun.durum', 1)
			->orderBy('urun_fiyat.fiyat', 'asc')
			->distinct('urun_kategori.id')
			->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')
			->get(); 
			$gelenBaslangicFiyat = null;
			$gelenBitisFiyat = $fiyat->max('fiyat'); 
			$kategori = $kategoriBul;

			return view('tanitim.shop.kategoriAlt', compact('urunler', 'gelenMarka', 'gelenEtiket', 'kategoriAltlar', 'kategori', 'random', 'kategoriAlt', 'markalar','filtreler', 'ustKategori', 'filtreFiyat', 'gelenBitisFiyat', 'gelenBaslangicFiyat'));
		}

		public function kategoriAltFilter($kategori, $kategoriAlt){
			$ulkeId = $this->ulkeIdBul();
			$data = request()->all();

			$gelenMarka = [];
			$gelenEtiket = []; 
			$gelenBaslangicFiyat = "0"; 
			$gelenBitisFiyat = "100000";
			if (isset($data['price_start'])) {
				$gelenBaslangicFiyat = $data['price_start']; 
			} 
			if (isset($data['price_finish'])) { 
				$gelenBitisFiyat = $data['price_finish']; 
			} 

			$filtreFiyat = "";
			$ustKategori = Kategori::whereSlug($kategori)->firstOrFail();
			$kategoriBul = Kategori::whereSlug($kategoriAlt)->firstOrFail();
			$kategoriAltlar = Kategori::where('ust_id', $kategoriBul->id)
			->where('durum', 1)
			->orderBy('sira', 'asc')
			->get();


			$random = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
			->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->select('urun.*','kategori.durum', 'marka.durum') 
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null)
			->where('marka.durum', 1)
			->where('marka.deleted_at', '=', null)
			->where('urun_kategori.deleted_at', '=', null)
			->where('urun.durum', 1)
			->inRandomOrder()
			->distinct('urun_kategori')
			->take(9)
			->get();

			$kategoriAlt = Kategori::where('slug', $kategoriAlt)->first();

			if(isset($data['markalar']) and !isset($data['etiketler'])){
				$urun = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')		
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('kategori.deleted_at', '=', null)
				->where('kategori.durum', 1)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->WhereIn('marka', $data['markalar'])
				->where('urun_fiyat.fiyat', '>', $gelenBaslangicFiyat)
				->where('urun_fiyat.fiyat', '<', $gelenBitisFiyat)
				->orderBy('urun_fiyat.fiyat','asc')
				->distinct('urun_kategori.id')
				->paginate(16);

				$gelenMarka = $data['markalar'];
			}
			if(!isset($data['markalar']) and isset($data['etiketler'])){
				$urun = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_etiket.etiket_id', 'urun_fiyat.fiyat')		
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun_etiket.deleted_at', '=', null)
				->where('urun.durum', 1)
				->WhereIn('urun_etiket.etiket_id', $data['etiketler'])
				->where('urun_fiyat.fiyat', '>', $gelenBaslangicFiyat)
				->where('urun_fiyat.fiyat', '<', $gelenBitisFiyat)
				->orderBy('urun_fiyat.fiyat','asc')
				->distinct('urun_kategori.id')
				->paginate(16); 

				$gelenEtiket = $data['etiketler']; 
			}
			if(isset($data['markalar']) and isset($data['etiketler'])){
				$urun = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_etiket', 'urun.id', '=', 'urun_etiket.urun_id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_etiket.etiket_id', 'urun_fiyat.fiyat')	
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun.deleted_at', '=', null) 
				->where('urun_etiket.deleted_at', '=', null)
				->where('urun.durum', 1) 
				->WhereIn('urun_etiket.etiket_id', $data['etiketler'])
				->WhereIn('marka', $data['markalar'])
				->where('urun_fiyat.fiyat', '>', $gelenBaslangicFiyat)
				->where('urun_fiyat.fiyat', '<', $gelenBitisFiyat)
				->orderBy('urun_fiyat.fiyat','asc')
				->distinct('urun_kategori.id')
				->paginate(16);  

				$gelenMarka = $data['markalar'];
				$gelenEtiket = $data['etiketler']; 
			}
			if(!isset($data['markalar']) and !isset($data['etiketler'])){
				$urun = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
				->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
				->join('marka', 'urun.marka', '=', 'marka.id')
				->join('urun_fiyat', 'urun.id' ,'=', 'urun_fiyat.urun_id')
				->select('urun.*','kategori.durum', 'urun_kategori.kategori_id','marka.durum', 'urun_fiyat.fiyat')
				->where('kategori.durum', 1)
				->where('kategori.deleted_at', '=', null)
				->where('marka.durum', 1)
				->where('marka.deleted_at', '=', null)
				->where('urun_kategori.kategori_id', $kategoriBul->id)
				->where('urun_kategori.deleted_at', '=', null) 
				->where('urun_fiyat.deleted_at', '=', null)
				->where('urun_fiyat.ulke_id', $ulkeId)
				->where('urun.deleted_at', '=', null) 
				->where('urun.durum', 1)
				->where('urun_fiyat.fiyat', '>=', $gelenBaslangicFiyat)
				->where('urun_fiyat.fiyat', '<=', $gelenBitisFiyat)
				->orderBy('urun_fiyat.fiyat','asc')
				->distinct('urun_kategori.id')
				->paginate(16);
			}
			//$urunler = $this->super_unique($urun,'urun_id');

			$urunler = $urun;
			$markalar = UrunKategori::where('kategori_id', $kategoriBul->id)
			->join('urun', 'urun_kategori.urun_id', '=','urun.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->where('marka.durum',1)
			->where('marka.deleted_at', null) 
			->where('urun.deleted_at', null) 
			->where('urun.durum',1)
			->where('urun_kategori.deleted_at',null)
			->select('marka.*',) 
			->distinct("urun.marka")
			->orderBy('marka.ad', 'asc')
			->get();

			$filtreler = Filtre::join('filtre_kategori', 'filtre.id', '=', 'filtre_kategori.filtre_id')
			->where('filtre_kategori.kategori_id', $kategoriAlt->id)
			->where('filtre_kategori.deleted_at', '=', null) 
			->where('filtre.deleted_at', '=', null) 
			->where('durum', 1)
			->get(); 
			$kategori = $kategoriBul;

			return view('tanitim.shop.kategoriAlt', compact('urunler', 'gelenMarka','gelenEtiket', 'kategoriAltlar', 'kategori', 'random', 'kategoriAlt', 'markalar','filtreler', 'ustKategori', 'gelenBaslangicFiyat', 'gelenBitisFiyat' ,'filtreFiyat'));
		}

		public function urun($urun){
			$ulkeId = $this->ulkeIdBul();

			$urun = Urun::where('urun.slug', $urun)
			->join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
			->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->select('urun.*','kategori.durum', 'marka.durum') 
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null) 
			->where('urun_kategori.deleted_at', '=', null) 
			->where('marka.durum', 1)
			->where('marka.deleted_at', '=', null) 
			->where('urun.deleted_at', '=', null)
			->firstOrFail();  

			$urunKategoriler = UrunKategori::join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null)
			->where('urun_id', $urun->id)
			->get();

			$benzerKat = UrunKategori::where('urun_id', $urun->id)->first();


			$random = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
			->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->select('urun.*','kategori.durum', 'marka.durum') 
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null)
			->where('marka.durum', 1)
			->where('marka.deleted_at', '=', null)
			->where('urun_kategori.deleted_at', '=', null)
			->where('urun.durum', 1)
			->inRandomOrder()
			->distinct('urun_kategori')
			->take(8)
			->get();


			$benzer = Urun::join('urun_kategori', 'urun.id', '=', 'urun_kategori.urun_id')
			->join('kategori', 'urun_kategori.kategori_id', '=', 'kategori.id')
			->join('marka', 'urun.marka', '=', 'marka.id')
			->select('urun.*','kategori.durum') 
			->where('kategori.durum', 1)
			->where('kategori.deleted_at', '=', null) 
			->where('marka.durum', 1)
			->where('marka.deleted_at', '=', null)  
			->where('urun.deleted_at', '=', null)
			->where('urun_kategori.deleted_at', '=', null)
			->where('urun.durum', 1)
			->where('urun_kategori.kategori_id', $benzerKat->kategori_id)		
			->inRandomOrder()
			->distinct('urun_kategori')
			->take(8)
			->get(); 

			$etiketBenzer= Etiket::join('urun_etiket', 'etiket.id','=','urun_etiket.etiket_id')
			->where('urun_etiket.urun_id', $urun->id)
			->where('urun_etiket.deleted_at', '=', null)  
			->where('etiket.deleted_at', '=', null)  
			->where('etiket.durum',1)
			->get(); 

			$marka= Marka::where('id',$urun->marka)->where('durum',1)->first();
			$yorumlar = Yorum::where('urun_id',$urun->id)->where('durum',1)->paginate(2);
			$yorum = Yorum::where('urun_id',$urun->id)->where('durum',1)->get();
			$analiz = UrunAnaliz::where('urun_id', $urun->id)->first();
			$tiklama = $analiz->tiklama + 1;
			$sonAnaliz = UrunAnaliz::where('urun_id', $urun->id)->update([
				'tiklama'=>$tiklama 
			]);
			return view('tanitim.shop.urun', compact('urun','analiz' ,'urunKategoriler',  'random', 'benzer', 'etiketBenzer', 'marka', 'yorumlar', 'yorum'));
		}

		public function urunHaberVer($urun_id, $user_id){
			$istek = UrunHaberVer::where('user_id', $user_id)->where('urun_id', $urun_id)->first();
			if (isset($istek)) {
				return back()
				->with('mesaj', 'Talebiniz alınmıştır.')
				->with('mesaj_tur', 'danger');
			}
			UrunHaberVer::create(['user_id' => $user_id, 'urun_id' => $urun_id]); 
			
			return back()
			->with('mesaj', 'Talebiniz alınmıştır.')
			->with('mesaj_tur', 'success');
		}
		public function yorum($user_id, $urun_id){
			$data = request()->all();
			$yorum = Yorum::create([
				'user_id' => $user_id,
				'urun_id' => $urun_id,
				'oy' => $data['rating'],
				'yorum' => $data['yorum'],
				'durum' => 0
			]);			
			return back();
		}
		public function yorumlar($urun){
			$data = request()->all();
			$urun = Urun::where('slug', $urun)->first();
			$yorumlar = Yorum::where('urun_id',$urun->id)->where('durum',1)->get();
			return view('tanitim.yorum', compact('yorumlar', 'urun'));

		}
	}



