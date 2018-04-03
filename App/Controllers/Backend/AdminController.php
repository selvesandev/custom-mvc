<?php

namespace Application\App\Controllers\Backend;

use Application\App\Controllers\Controller;
use Application\App\Models\Admin;
use Application\App\Models\Privilege;
use Application\System\Database;
use Application\System\Session;
use Application\System\Validation;
use Intervention\Image\ImageManager;

class AdminController extends Controller
{
    private $_data = [];
    private $_view = 'Backend/master';

    private $_admin;
    private $_privileges;

    public function __construct()
    {
        $this->_admin = new Admin();
        $this->_privileges = new Privilege();
    }

    public function index()
    {
        $db = Database::instantiate();

        if (isset($_GET['search']) || !empty($_GET['search'])) {
            $query = "SELECT admins.id, admins.name, admins.email, 
admins.image, admins.status, admins.created_at, 
GROUP_CONCAT(privileges.type SEPARATOR ',') as privileges_type 
FROM admins JOIN admins_privileges ON 
admins.id=admins_privileges.admin_id JOIN privileges ON privileges.id=admins_privileges.privilege_id 
WHERE admins.name LIKE '%" . $_GET['search'] . "%' GROUP BY admins.id";
        } else {
            $query = "SELECT admins.id,
                          admins.name,
                          admins.email,
                          admins.image,
                          admins.status,
                          admins.created_at,
                          GROUP_CONCAT(privileges.type SEPARATOR ',') as privileges_type
                           FROM admins JOIN admins_privileges 
                           ON admins.id=admins_privileges.admin_id 
                           JOIN privileges 
                           ON privileges.id=admins_privileges.privilege_id 
                           GROUP BY admins.id";

        }
        $data = $db->query($query);

        $this->_data['page'] = 'admin.php';
        $this->_data['title'] = 'Admins';
        $this->_data['admins'] = $data;

        return view($this->_view, $this->_data);
    }

    public function add()
    {
        $this->_data['page'] = 'add-admin.php';
        $this->_data['title'] = 'Add Admin';
        $this->_data['privileges'] = $this->_privileges->getAll();
        return view($this->_view, $this->_data);
    }


    /**
     * Create New Admin
     * @return $this|bool
     */
    public function addAction()
    {
        $validate = new Validation();
        $rules = [
            'name' => 'required|min:3|max:20|exact:20',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|matches:password',
            'privileges' => 'required',
            'image' => 'required|extension:jpeg,jpg,png,gif'
        ];


        $validate->validate($rules);

        if (!$validate->isValid()) {
            Session::set('validation_errors', $validate->getErrors());
            return redirect()->back();
        }

        $name = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];
        $newName = time() . '_' . $name;
        $intervention = new ImageManager(['diver' => 'gd']);

        $intervention->make($tmpName)->resize(200, null, function ($ratio) {
            $ratio->aspectRatio();
        })->crop(200, 200)->save(rootPath('/public/Uploads/admins/' . $newName));

        $data['image'] = $newName;
        $data['name'] = $_POST['name'];
        $data['email'] = $_POST['email'];
        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        if ($lastAdminId = $this->_admin->insert($data)) {
            $privileges = $_POST['privileges'];
            $db = Database::instantiate();
            foreach ($privileges as $privilege) {
                $privilegeData['admin_id'] = $lastAdminId;
                $privilegeData['privilege_id'] = $privilege;
                $db->insert('admins_privileges', $privilegeData);
            }
            Session::set('success', 'Admin was created');
            return redirect()->to('admin');
        }
    }

    public function delete()
    {
        if (!isset($_GET['id'])) return redirect()->back();
        $id = (int)$_GET['id'];

        //Delete Admin Image

        //Delete Admin Privilages

        if ($this->_admin->delete($id)) {
            Session::set('success', 'Admin was deleted');
            return redirect()->back();
        }
        Session::set('fail', 'There was some problem');
        return redirect()->back();
    }


    public function viewProfile()
    {
        $this->_data['page'] = 'profile.php';
        $this->_data['title'] = 'Profile';

        $loggedUser = $this->_admin->user();

        if (!$loggedUser) return redirect()->back();

        $loggedUserId = $loggedUser->id;

        $db = Database::instantiate();
        $query = "SELECT admins.id,
                          admins.name,
                          admins.email,
                          admins.image,
                          admins.status,
                          admins.created_at,
                          GROUP_CONCAT(privileges.type SEPARATOR ',') as privileges_type
                           FROM admins JOIN admins_privileges 
                           ON admins.id=admins_privileges.admin_id 
                           JOIN privileges 
                           ON privileges.id=admins_privileges.privilege_id WHERE admins.id=$loggedUserId
                           GROUP BY admins.id";
        $loggedUser = $db->query($query);

        if (!count($loggedUser)) return redirect()->back();

        $this->_data['loggedUser'] = $loggedUser[0];
        $this->_data['privileges'] = $this->_privileges->getAll();

        return view($this->_view, $this->_data);
    }


    public function updateProfileInfo()
    {
        if (!isset($_POST['_id']) || empty($_POST['_id'])) return redirect()->back();
        $id = (int)$_POST['_id'];

        $validate = new Validation();
        $rules = [
            'name' => 'required|min:3|max:20',
            'email' => 'required|email|unique:admins,email,id:' . $id,
            'privileges' => 'required',
            'image' => 'extension:jpeg,jpg,png,gif'
        ];
        $validate->validate($rules);

        if (!$validate->isValid()) {
            Session::set('validation_errors', $validate->getErrors());
            return redirect()->back();
        }

        $data['name'] = $_POST['name'];
        $data['email'] = $_POST['email'];

        $hasFile = !($_FILES['image']['error'] === 4);


        $admin = $this->_admin->find($id);

        if ($hasFile) {
            $oldImage = $admin->image;
            if (!empty($oldImage) && file_exists(rootPath('public/Uploads/admins/' . $oldImage))) {
                unlink(rootPath('public/Uploads/admins/' . $oldImage));
            }

            $name = $_FILES['image']['name'];
            $tmpName = $_FILES['image']['tmp_name'];
            $newName = time() . '_' . $name;
            $intervention = new ImageManager(['diver' => 'gd']);

            $intervention->make($tmpName)->resize(200, null, function ($ratio) {
                $ratio->aspectRatio();
            })->crop(200, 200)->save(rootPath('/public/Uploads/admins/' . $newName));
            $data['image'] = $newName;
        }

        if (!$this->_admin->update($data, $id)) return redirect()->back();

        //privilege update
        $db = Database::instantiate();
        $db->where(['admin_id' => $id])->delete('admins_privileges');

        $privilegeData['admin_id'] = $id;
        $privileges = $_POST['privileges'];
        foreach ($privileges as $privilege) {
            $privilegeData['privilege_id'] = $privilege;
            $db->insert('admins_privileges', $privilegeData);
        }
        Session::set('success', 'Profile Updated');
        return redirect()->back();
    }


    public function updatePassword()
    {
        $validation = new Validation();
        $validation->validate([
            'password' => 'required|min:6',
            'password_confirmation' => 'required|matches:password',
            'old_password' => 'required'
        ]);


        if (!$validation->isValid()) {
            Session::set('validation_errors', $validation->getErrors());
            return redirect()->back();
        }
        if (!isset($_POST['_id']) || empty($_POST['_id'])) return redirect()->back();
        $id = (int)$_POST['_id'];

        $admin = $this->_admin->find($id);

        if (!password_verify($_POST['old_password'], $admin->password)) {
            Session::set('fail', 'Old password does not match');
            return redirect()->back();
        }

        $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $this->_admin->update($data, $id);

        Session::set('success', 'Password Updated');
        $this->_admin->logout();
        return redirect()->to('/@admin@login');
    }

}