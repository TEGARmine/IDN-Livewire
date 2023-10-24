<?php

namespace App\Livewire;

use App\Models\CabangIdn;
use App\Models\ProgramIdn;
use App\Models\Santri;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormSantri extends Component
{
    use WithFileUploads;

    #[Rule('required|email')]
    public $email;

    #[Rule('required')]
    public $password;

    #[Rule('required')]
    public $namaSantri;

    #[Rule('required')]
    public $jenisKelamin;

    #[Rule('required')]
    public $cabangIdn;

    #[Rule('required')]
    public $programIdn;

    #[Rule('required|image|max:1024|mimes:jpg,jpeg,png')]
    public $image;
    public $uploadProgress = 0;

    public $cabangIdns = [];
    public $programIdns = [];
    public $optionProgram = false;

    public $kuotaFull = false;
    public $berhasilDaftar = false;

    private $programIdnModel;

    public function boot(ProgramIdn $programIdnModel)
    {
        $this->programIdnModel = $programIdnModel;
    }

    public function mount()
    {
        $this->cabangIdns = CabangIdn::all();
    }

    public function updatedCabangIdn()
    {
        if ($this->cabangIdn) {
            $this->programIdns = ProgramIdn::where('cabangidn_id', $this->cabangIdn)->get();
            $this->optionProgram = true;
        }
    }

    public function updatedProgramIdn()
    {
        $this->cabangJonggolIkhwan();

        $this->cabangJonggolAkhwat();

        $this->cabangSentul();
    }

    public function cabangJonggolIkhwan()
    {
        if ($this->cabangIdn == 1) {

            $this->kuotaFull = false;

            foreach ($this->cabangIdns as $cabang) {
                if ($cabang->id == 1) {
                    $programIdn = $this->programIdnModel->find($this->programIdn);
                    $cabangIdn = $cabang->nama_cabang;
                    if ($this->programIdn == 1) {

                        if ($cabang->kuota_smp >= 5) {
                            $this->kuotaFull = true;
                            $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                        }
                    }
                    if ($this->programIdn == 2) {
                        if ($cabang->kuota_tkj >= 5) {
                            $this->kuotaFull = true;
                            $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                        }
                    }
                    if ($this->programIdn == 3) {
                        if ($cabang->kuota_rpl >= 5) {
                            $this->kuotaFull = true;
                            $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                        }
                    }
                    if ($this->programIdn == 4) {
                        if ($cabang->kuota_dkv >= 5) {
                            $this->kuotaFull = true;
                            $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                        }
                    }
                }
            }
        }
    }

    public function cabangJonggolAkhwat()
    {
        if ($this->cabangIdn == 2) {

            $this->kuotaFull = false;

            foreach ($this->cabangIdns as $cabang) {
                $programIdn = $this->programIdnModel->find($this->programIdn);
                $cabangIdn = $cabang->nama_cabang;
                if ($cabang->id == 2) {
                    if ($this->programIdn == 5) {
                        if ($cabang->kuota_smp >= 5) $this->kuotaFull = true;
                        $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                    }
                    if ($this->programIdn == 6) {
                        if ($cabang->kuota_rpl >= 5) $this->kuotaFull = true;
                        $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                    }
                    if ($this->programIdn == 7) {
                        if ($cabang->kuota_dkv >= 5) $this->kuotaFull = true;
                        $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                    }
                }
            }
        }
    }

    public function cabangSentul()
    {
        if ($this->cabangIdn == 3) {
            $this->kuotaFull = false;

            foreach ($this->cabangIdns as $cabang) {
                $programIdn = $this->programIdnModel->find($this->programIdn);
                $cabangIdn = $cabang->nama_cabang;
                if ($cabang->id == 3) {
                    if ($this->programIdn == 8) {
                        if ($cabang->kuota_smp >= 5) {
                            $this->kuotaFull = true;
                            $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                        }
                    }
                    if ($this->programIdn == 9) {
                        if ($cabang->kuota_tkj >= 5) {
                            $this->kuotaFull = true;
                            $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                        }
                    }
                    if ($this->programIdn == 10) {
                        if ($cabang->kuota_rpl >= 5) {
                            $this->kuotaFull = true;
                            $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                        }
                    }
                    if ($this->programIdn == 11) {
                        if ($cabang->kuota_dkv >= 5) {
                            $this->kuotaFull = true;
                            $this->dispatch('kuotaFull', [true, $programIdn->name, $cabangIdn]);
                        }
                    }
                }
            }
        }
    }

    public function store()
    {
        $validate = $this->validate();
        $cekEmail = Santri::where('username', $validate['email'])->first();

        if ($cekEmail && $cekEmail->username === $validate['email']) {
            $validate = $this->validate([
                'email' => 'required|email|unique:santri,username'
            ], [
                'email.unique' => 'Email sudah terdaftar, silahkan login disini'
            ]);
            return;
        }

        $imageName = '';

        if ($this->image) {
            $imageName = \Str::slug($this->namaSantri, '-')
                . '-'
                . uniqid()
                . '.' . $this->image->getClientOriginalExtension();

            $this->image->storeAs('public', $imageName, 'local');
        }

        $santri = Santri::create([
            'cabangidn_id' => $validate['cabangIdn'],
            'programidn_id' => $validate['programIdn'],
            'username' => $validate['email'],
            'password' => $validate['password'],
            'nama_santri' => $validate['namaSantri'],
            'jenis_kelamin' => $validate['jenisKelamin'],
            'bukti_transfer' => $imageName
        ]);

        $this->dispatch('daftarBerhasil', true);
        return $this->berhasilDaftar = true;
    }

    public function render()
    {
        return view('livewire.form-santri');
    }
}
