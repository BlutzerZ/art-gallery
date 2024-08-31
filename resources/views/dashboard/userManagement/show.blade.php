<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body>
  <h1 class="text-3xl font-bold underline">
    Dashboard | Art Gallery
  </h1>

  <div id="content">
    <div class="container">
      <h1>User Management</h1>
  
      @if(session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
      @endif
  
      @if(session('error'))
          <div class="alert alert-danger">
              {{ session('error') }}
          </div>
      @endif
  
      <table class="table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>NIM</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tbody>
              @foreach($users as $user)
              <tr>
                  <td>{{ $user->id }}</td>
                  <td>{{ $user->nim }}</td>
                  <td>{{ $user->name }}</td>
                  <td>
                      <form action="{{ route('userManagement.edit') }}" method="POST" style="display: inline-block;">
                          @csrf
                          <input type="hidden" name="id" value="{{ $user->id }}">
                          <div class="form-group">
                              <select name="role" class="form-control">
                                  <option value="organizer" {{ $user->role == 'organizer' ? 'selected' : '' }}>Organizer</option>
                                  <option value="participant" {{ $user->role == 'participant' ? 'selected' : '' }}>Participant</option>
                                  <option value="visitor" {{ $user->role == 'visitor' ? 'selected' : '' }}>Visitor</option>
                              </select>
                          </div>
                  </td>
                  <td>
                          <button type="submit" class="btn btn-success">Save</button>
                      </form>
                  </td>
              </tr>
              @endforeach
          </tbody>
      </table>
  </div>
  </div>

</body>
</html>