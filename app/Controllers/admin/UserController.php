<?php

namespace app\Controllers\Admin;

use CodeIgniter\Shield\Entities\User;
use App\Models\UserModel;
use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;


class UserController extends BaseController
{

  protected $db;
  protected $userModel;

  public function __construct()
  {
    $this->db = db_connect();
    $this->userModel = new UserModel();
  }

  public function index()
  {
    if (session('magicLogin')) {
      return redirect()->route('user.passwordreset');
    }

    $UsersNos = 0;
    $PartyNos = 0;
    $ItemsNos = 0;
    $SitesNos = 0;
    $PurchasesNos = 0;
    $OrdersNos = 0;
    $DeliveryNos = 0;
    $SalesNos = 0;

    if ($this->db->tableExists('users')) {
      $UsersNos = $this->db->table('users')->countAll();
    };
    if ($this->db->tableExists('party')) {
      $PartyNos = $this->db->table('party')->countAll();
    };
    if ($this->db->tableExists('items')) {
      $ItemsNos = $this->db->table('items')->countAll();
    };
    if ($this->db->tableExists('site')) {
      $SitesNos = $this->db->table('site')->countAll();
    };
    if ($this->db->tableExists('orders')) {
      $OrdersNos = $this->db->table('orders')->countAll();
    };
    if ($this->db->tableExists('delivery')) {
      $DeliveryNos = $this->db->table('delivery')->countAll();
    };
    if ($this->db->tableExists('sales')) {
      $SalesNos = $this->db->table('sales')->countAll();
    };
    if ($this->db->tableExists('purchases')) {
      $PurchasesNos = $this->db->table('purchases')->countAll();
    };
    $data = [
      'pageTitle' => 'Home',
      'UsersNos' => $UsersNos,
      'PartyNos' => $PartyNos,
      'ItemsNos' => $ItemsNos,
      'SitesNos' => $SitesNos,
      'OrdersNos' => $OrdersNos,
      'DeliveryNos' => $DeliveryNos,
      'SalesNos'  => $SalesNos,
      'PurchasesNos' => $PurchasesNos,
    ];
    return view('admin/dashboard/home', $data);
  }

  public function profile()
  {
    // Get the User Provider (UserModel by default)
    $users = auth()->getProvider();

    $id = auth()->id();

    $userInfo = $users->findById($id);

    $data = [
      'pageTitle' => 'Profile',
      'User' => $userInfo,
    ];

    return view('admin/users/profile', $data);
  }

  public function getUserInfo()
  {
    $cid = $this->request->getPost('user_id');

    $users = auth()->getProvider();

    $info = $users->findById($cid);

    $groups = $info->getGroups();

    if ($info) {
      echo json_encode(['code' => 1, 'msg' => '', 'results' => $info, 'groups' => $groups]);
    } else {
      echo json_encode(['code' => 0, 'msg' => 'No results found', 'results' => null]);
    }
  }
  public function listUsers()
  {
    $data['pageTitle'] = 'Users Management';
    return view('admin/users/index', $data);
  }

  public function getAllUsers()
  {
    $builder = $this->userModel->select('id, username,first_name,last_name,phone_number,gender,created_at,updated_at,last_active,status,active')->where('deleted_at', null);

    return DataTable::of($builder)->addNumbering()
      ->format('created_at', function ($value, $meta) {
        return ($value) ? date('d-m-Y H:i:s', strtotime($value)) : "";
      })
      ->format('updated_at', function ($value, $meta) {
        return ($value) ? date('d-m-Y H:i:s', strtotime($value)) : "";
      })
      ->format('last_active', function ($value, $meta) {
        return ($value) ? date('d-m-Y H:i:s', strtotime($value)) : "";
      })
      ->format('active', function ($value, $meta) {
        return ($value == 1) ? 'Yes' : 'No';
      })
      ->add('action', function ($row) {
        return "<div class='btn-group'>
		<button class='btn btn-sm btn-primary mr-2 updateUserBtn' data-id='" . $row->id . "' title='Update'><i class='far fa-edit'></i></button>
    <button class='btn btn-sm btn-warning mr-2 disableUserBtn' data-url = '" . route_to('disable.user') . "' data-id='" . $row->id . "' title='Disable'>(Un)Ban</button>
		<button class='btn btn-sm btn-danger deleteUserBtn' data-url = '" . route_to('delete.user') . "' data-id='" . $row->id . "' title='Delete'><i class='fas fa-trash'></i></button>
		 </div>";
      }, 'last')
      ->hide('id')
      ->toJson();
  }

  private function _getValidationRules(?int $userId = null): array
  {
    // Base rules are the same for add and update
    $rules = [
      'username' => [
        'label' => 'Auth.username',
        'rules' => [
          'required',
          'max_length[30]',
          'min_length[3]',
          'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
          // is_unique is handled below
        ],
      ],
      'password' => [
        'label' => 'Auth.password',
        'rules' => [
          'required',
          'max_byte[72]',
          'strong_password[]',
        ],
        'errors' => [
          'max_byte' => 'Auth.errorPasswordTooLongBytes'
        ]
      ],
      'password_confirm' => [
        'label' => 'Auth.passwordConfirm',
        'rules' => 'required|matches[password]',
      ],
      'gender' => [
        'rules' => 'required|in_list[male,female,bisexual]',
        'errors' => [
          'in_list' => 'Not in the list'
        ],
      ],
      'first_name' => [
        'rules' => 'required|alpha|min_length[3]|max_length[10]',
        'errors' => [
          'required' => 'User First Name is required',
          'alpha' => 'only Alphanumeric is allowed',
          'min_length[3]' => 'Minimum 3 letters',
          'max_length[10]' => 'Maximum 10 letters',
        ]
      ],
      'last_name' => [
        'rules' => 'required|alpha|min_length[3]|max_length[15]',
        'errors' => [
          'required' => 'User First Name is required',
          'alpha' => 'only Alphanumeric is allowed',
          'min_length[3]' => 'Minimum 3 letters',
          'max_length[15]' => 'Maximum 15 letters',
        ]
      ],
      'phone_number' => [
        'rules' => 'required|regex_match[/^[0-9]{10}$/]',
        'errors' => [
          'required' => 'Phone Number is required',
          'regex_match[/^[0-9]{10}$/]' => 'only 10 digit number is allowed',
        ]
      ],
    ];

    // Add is_unique rule for username, ignoring the current user on update
    $rules['username']['rules'][] = 'is_unique[users.username,id,' . ($userId ?? '0') . ']';

    // For adding a user, email is required and must be unique
    if ($userId === null) {
      $rules['email'] = [
        'label' => 'Auth.email',
        'rules' => [
          'required',
          'max_length[254]',
          'valid_email',
          'is_unique[auth_identities.secret]',
        ],
      ];
    }

    return $rules;
  }

  public function addUser()
  {

    if (!auth()->user()->can('users.create')) {
      $message = 'You are not Allowed to create a new user !!';
      echo "<script>alert('$message');</script>";
      return;
    }

    $validation = \Config\Services::validation();

    $this->validate($this->_getValidationRules());

    if ($validation->run() == FALSE) {
      $errors = $validation->getErrors();
      echo json_encode(['code' => 0, 'error' => $errors]);
    } else {
      // Get the User Provider (UserModel by default)
      $users = auth()->getProvider();

      $formData = $this->request->getPost(null, FILTER_UNSAFE_RAW);

      $userData = new User([
        'username' => $formData['username'],
        'email' => $formData['email'],
        'password' => $formData['password'],
        'first_name' => $formData['first_name'],
        'last_name' => $formData['last_name'],
        'gender' => $formData['gender'],
        'phone_number' => $formData['phone_number'],
      ]);

      $users->save($userData);

      // To get the complete user object with ID, we need to get from the database
      $newuser = $users->findById($users->getInsertID());

      // Add to default group
      $users->addToDefaultGroup($newuser);

      if (isset($newuser)) {
        echo json_encode(['code' => 1, 'msg' => 'User info have been updated successfully']);
      } else {
        echo json_encode(['code' => 0, 'msg' => 'Something went wrong']);
      }
    }
  }

  public function update()
  {

    if (!auth()->user()->can('users.create')) {
      $message = 'You are not Allowed to Edit user !!';
      echo "<script>alert('$message');</script>";
      return;
    }

    $validation = \Config\Services::validation();

    $id = $this->request->getPost('id');

    $this->validate($this->_getValidationRules($id));

    if ($validation->run() == FALSE) {
      $errors = $validation->getErrors();
      echo json_encode(['code' => 0, 'error' => $errors]);
    } else {

      $formData = $this->request->getPost(null, FILTER_UNSAFE_RAW);

      $users = auth()->getProvider();

      $user = $users->findById($id);

      $data = [
        'username' => $formData['username'],
        'password' => $formData['password'],
        'first_name' => $formData['first_name'],
        'last_name' => $formData['last_name'],
        'gender' => $formData['gender'],
        'phone_number' => $formData['phone_number'],
      ];

      $user->fill($data);

      $flag = $users->save($user);

      $user->addGroup($formData['usertype']);

      $user->syncGroups($formData['usertype']);

      if ($flag) {
        echo json_encode(['code' => 1, 'msg' => 'User info have been updated successfully']);
      } else {
        echo json_encode(['code' => 0, 'msg' => 'Something went wrong']);
      }
    }
  }

  public function disableUser()
  {
    $user_id = $this->request->getPost('id');

    // Get the User Provider (UserModel by default)
    $users = auth()->getProvider();

    $user = $users->findById($user_id);

    if ($user->isBanned()) {
      $flag = $user->unBan();
      $msg = 'User Enabled Successfully !';
    } else {
      $reason = 'Banned by ' . auth()->user()->username;
      $msg = 'User Disabled Successfully' . $reason;
      $flag = $user->ban($reason);
      //$flag = $user->ban();
    }


    if ($flag) {
      echo json_encode(['code' => 1, 'msg' => $msg]);
    } else {
      echo json_encode(['code' => 0, 'msg' => 'Something went wrong']);
    }
  }

  public function passwordReset()
  {
    $data['pageTitle'] = 'Password Reset';
    return view('admin/users/resetpassword', $data);
  }

  public function savePassword()
  {
    $validation = \Config\Services::validation();

    $this->validate([
      'password' => [
        'label' => 'Auth.password',
        'rules' => [
          'required',
          'max_byte[72]',
          'strong_password[]',
        ],
        'errors' => [
          'max_byte' => 'Auth.errorPasswordTooLongBytes'
        ]
      ],
      'password_confirm' => [
        'label' => 'Auth.passwordConfirm',
        'rules' => 'required|matches[password]',
      ]
    ]);
    if ($validation->run() == FALSE) {
      $errors = $validation->getErrors();
      echo json_encode(['code' => 0, 'error' => $errors]);
    } else {
      // Get the User Provider (UserModel by default)
      $users = auth()->getProvider();

      $formData = $this->request->getPost(null, FILTER_UNSAFE_RAW);

      $user = auth()->user();

      $user->fill([
        'password' => $formData['password'],
      ]);

      $flag =  $users->save($user);

      if ($flag) {
        if (session('magicLogin')) {
          // Unset the magicLogin session
          session()->remove('magicLogin');

          // Get the current user's identity
          $identity = $user->getAuthIdentity();
          // Unset the force_reset flag
          $users->undoForceReset($identity->id);
        }

        echo json_encode(['code' => 1, 'msg' => 'Password updated successfully']);
      } else {
        echo json_encode(['code' => 0, 'msg' => 'Something went wrong']);
      }
    }
  }

  public function delete()
  {
    $user_id = $this->request->getPost('id');

    // Get the User Provider (UserModel by default)
    $users = auth()->getProvider();

    $user = $users->findById($user_id);

    $flag = false;
    $msg = "";

    if ($user_id == auth()->id()) {
      $msg  = $msg . ' You can not Delete Self ';
    } else {
      $flag =  $users->delete($user_id, true);
    }

    if ($flag) {
      echo json_encode(['code' => 1, 'msg' => 'User Deleted Successfully : ' . $user->username]);
    } else {
      echo json_encode(['code' => 0, 'msg' => 'Something went wrong : ' . $msg]);
    }
  }
  public function permissionDenied()
  {
    $data['pageTitle'] = 'Permission Denied';

    return view('admin/users/permissiondenied', $data);
  }
}
