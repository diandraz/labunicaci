<?php

namespace App\Controllers;

use App\Models\RegistrasiModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        // Generate captcha random
        $captcha = $this->generateCaptcha();
        session()->set('captcha_code', $captcha);
        
        return view('login_form', ['captcha' => $captcha]);
    }

    public function auth()
    {
        $session = session();
        $model = new RegistrasiModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $captcha_input = $this->request->getPost('captcha');
        $captcha_session = $session->get('captcha_code');

        // Validasi captcha terlebih dahulu
        if (empty($captcha_input) || $captcha_input !== $captcha_session) {
            // Generate captcha baru untuk form selanjutnya
            $new_captcha = $this->generateCaptcha();
            $session->set('captcha_code', $new_captcha);
            
            return redirect()->back()->with('error', '❌ Kode captcha salah! Silakan coba lagi.')
                                   ->with('captcha', $new_captcha)
                                   ->withInput();
        }

        $user = $model->where('email', $email)->first();

        if ($user) {
            $passValid = password_verify($password, $user['password']);
            if ($passValid) {
                // Clear captcha dari session setelah login berhasil
                $session->remove('captcha_code');
                
                $session->set([
                    'logged_in'     => true,
                    'id_regis'      => $user['id_regis'],
                    'nama_lengkap'  => $user['nama_lengkap'],
                    'email'         => $user['email'],
                    'role'          => $user['role']
                ]);
                return redirect()->to('/dashboard');
            } else {
                // Generate captcha baru untuk form selanjutnya
                $new_captcha = $this->generateCaptcha();
                $session->set('captcha_code', $new_captcha);
                
                return redirect()->back()->with('error', '❌ Password salah.')
                                       ->with('captcha', $new_captcha)
                                       ->withInput();
            }
        } else {
            // Generate captcha baru untuk form selanjutnya
            $new_captcha = $this->generateCaptcha();
            $session->set('captcha_code', $new_captcha);
            
            return redirect()->back()->with('error', '❌ Email tidak ditemukan.')
                                   ->with('captcha', $new_captcha)
                                   ->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    /**
     * Generate random captcha (alphanumeric mix)
     */
    private function generateCaptcha($length = 5)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $captcha = '';
        
        for ($i = 0; $i < $length; $i++) {
            $captcha .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $captcha;
    }

    /**
     * Endpoint untuk refresh captcha via AJAX
     */
    public function refreshCaptcha()
    {
        $captcha = $this->generateCaptcha();
        session()->set('captcha_code', $captcha);
        
        return $this->response->setJSON([
            'success' => true,
            'captcha' => $captcha
        ]);
    }
}
