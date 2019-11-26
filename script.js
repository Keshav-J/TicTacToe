var bodyApp = angular.module("body", []);
bodyApp.controller("bodyCtrl", function($scope, $http) {
	$scope.init = function() {
		$scope.name = '';
		$scope.num = '';
		$scope.uname = '';
		$scope.pwd = '';
		//$scope.load = true;

		$scope.loginD = false;
		$scope.signupD = false;
		$scope.loginPanel = false;
	}

	$scope.loginS = function() {
		$scope.loginD = true;
		$scope.signupD = false;
	}
	$scope.signupS = function() {
		$scope.loginD = false;
		$scope.signupD = true;	
	}
	$scope.log_up = function() {
		$scope.loginPanel = true;
	}

	$scope.close = function() {
		$scope.loginPanel = false;
	}

	$scope.login = function() {
		if($scope.num=='' || $scope.num=='undefined' || $scope.pwd=='' || $scope.pwd=='undefined')
			return;

		$scope.load = true;
		$http({
			method : "POST",
			url    : "includes/login.inc.php?page=login",
			data   : {
				num : $scope.num,
				pwd   : $scope.pwd
			}
		}).then(function(data) {
			console.log(data.data);
			//console.log(data.data.status);
			$scope.load = false;

			if(data.data.num == 1)	$scope.numV = true;
			else					$scope.numV = false;
			
			if(data.data.pwd == 1)	$scope.pwdV = true;
			else					$scope.pwdV = false;

			if(data.data.status == 'success')
				window.location.reload();

			if(data.data.status == 'error')
				alert('Something went wrong. Try again or contact developer.');

		}, function myError(response) {
			console.log(response);
		});
	}

	$scope.signup = function() {
		if($scope.name=='' || $scope.name=='undefined' || $scope.num=='' || $scope.num=='undefined'
			|| $scope.uname=='' || $scope.uname=='undefined' || $scope.pwd=='' || $scope.pwd=='undefined')
			return;

		$scope.load = true;
		$http({
			method : "POST",
			url    : "includes/login.inc.php?page=signup",
			data   : {
				name  : $scope.name,
				num   : $scope.num,
				uname : $scope.uname,
				pwd   : $scope.pwd
			}
		}).then(function(data) {
			console.log(data.data);
			$scope.load = false;

			if(data.data.uname == 1)$scope.unameV = true;
			else					$scope.unameV = false;
			
			if(data.data.num == 1)	$scope.numV = true;
			else					$scope.numV = false;

			if(data.data.status == 'success')
				window.location.reload();

			if(data.data.status == 'error')
				alert('Something went wrong. Try again or contact developer.');

		}, function myError(response) {
			console.log(response);
		});
	}

	$scope.logout = function() {
		console.log('logout on process.');
		$scope.load = true;
		$http({
			method : "POST",
			url    : "includes/logout.inc.php",
			data   : {}
		}).then(function(data) {
			console.log('logged out!');
			$scope.load = false;
			window.location.reload();

		}, function myError(response) {
			console.log(response);
		});
	}

	$scope.checkUser = function() {
		$http({
			method : "POST",
			url    : "includes/login.inc.php?page=check",
			data   : {}
		}).then(function(data) {
			console.log(data.data);

			if(data.data == 'error')
				$scope.logout();

		}, function myError(response) {
			console.log(response);
		});
	}

	setInterval(function(){ 
	    $scope.checkUser();
	}, 3000);

	$scope.reset = function() {
		$scope.init();
		setTimeout(function(){ $scope.load = false; }, 200);
		
		$scope.loginD = true;
		//$scope.loginPanel = true;
	}
	$scope.reset();
});

bodyApp.controller("twoCtrl", function($scope, $http) {

	$scope.resetBoard = function() {
		$scope.board = [
				[0, 0, 0, 0],	
				[0, 0, 0, 0],	
				[0, 0, 0, 0],	
				[0, 0, 0, 0]	
			];
		$scope.count=0;
		$scope.start = !$scope.start;
		$scope.p2 = $scope.start;
	}
	$scope.init = function() {
		$scope.p2 = false;
		$scope.w1 = 0;
		$scope.w2 = 0;
		$scope.dw = 0;
		$scope.start = 1;
		$scope.resetBoard();
	}

	$scope.check = function() {
		//console.log($scope.board);
		if($scope.board[1][1]==$scope.p2+1 && $scope.board[1][2]==$scope.p2+1 && $scope.board[1][3]==$scope.p2+1)
			return true;
		if($scope.board[2][1]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[2][3]==$scope.p2+1)
			return true;
		if($scope.board[3][1]==$scope.p2+1 && $scope.board[3][2]==$scope.p2+1 && $scope.board[3][3]==$scope.p2+1)
			return true;

		if($scope.board[1][1]==$scope.p2+1 && $scope.board[2][1]==$scope.p2+1 && $scope.board[3][1]==$scope.p2+1)
			return true;
		if($scope.board[1][2]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[3][2]==$scope.p2+1)
			return true;
		if($scope.board[1][3]==$scope.p2+1 && $scope.board[2][3]==$scope.p2+1 && $scope.board[3][3]==$scope.p2+1)
			return true;

		if($scope.board[1][1]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[3][3]==$scope.p2+1)
			return true;
		if($scope.board[3][1]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[1][3]==$scope.p2+1)
			return true;

		return false;
	}

	$scope.change = function(rc) {
		$scope.load = true;
		//console.log(rc + ' ' + Math.floor(rc/10) + ' ' + rc%10);
		r = Math.floor(rc/10);
		c = rc%10;

		if($scope.board[r][c] == 0)
		{
			$scope.count++;
			$scope.board[r][c] = $scope.p2 + 1;
			//console.log($scope.board[r][c]);

			if($scope.check())
			{
				setTimeout(function() {
					alert('Player ' + ($scope.p2+1) + ' wins...!! Player ' + (!$scope.start+1) + ' starts now.');
					if($scope.p2 == 0)
						$scope.w1++;
					else
						$scope.w2++;
					$scope.resetBoard();
				}, 1000);
			}
			else if($scope.count == 9)
			{
				alert('Match drawn...!! Player ' + (!$scope.start+1) + ' starts now.');
				$scope.dw++;
				$scope.resetBoard();
				$scope.p2 = !$scope.p2;
			}
			else
				$scope.p2 = !$scope.p2;
			$scope.load = false;
		}
	}

	$scope.reset = function() {
		$scope.init();
	}
	$scope.reset();
});

bodyApp.controller("singleCtrl", function($scope, $http) {

	$scope.resetBoard = function() {
		$scope.board = [
				[0, 0, 0, 0],	
				[0, 0, 0, 0],	
				[0, 0, 0, 0],	
				[0, 0, 0, 0]	
			];
		$scope.count=0;
		$scope.start = !$scope.start;
		$scope.p2 = $scope.start;
	}
	$scope.init = function() {
		$scope.p2 = false;
		
		$http({
			method : "POST",
			url    : "includes/multi.inc.php?page=stats",
			data   : {
				uname : ''
			}
		}).then(function(data) {
			console.log(data.data);

			if(data.data == 'error')
			{
				$scope.w1 = 0;
				$scope.w2 = 0;
				$scope.dw = 0;
			}
			else
			{
				$scope.uname = data.data.uname;
				$scope.w1 = data.data.sw;
				$scope.w2 = data.data.sl;
				$scope.dw = data.data.sd;
			}
		}, function myError(error) {
			console.log(error);
		});

		$scope.start = 1;
		$scope.resetBoard();
	}

	$scope.check = function() {
		//console.log($scope.board);
		if($scope.board[1][1]==$scope.p2+1 && $scope.board[1][2]==$scope.p2+1 && $scope.board[1][3]==$scope.p2+1)
			return true;
		if($scope.board[2][1]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[2][3]==$scope.p2+1)
			return true;
		if($scope.board[3][1]==$scope.p2+1 && $scope.board[3][2]==$scope.p2+1 && $scope.board[3][3]==$scope.p2+1)
			return true;

		if($scope.board[1][1]==$scope.p2+1 && $scope.board[2][1]==$scope.p2+1 && $scope.board[3][1]==$scope.p2+1)
			return true;
		if($scope.board[1][2]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[3][2]==$scope.p2+1)
			return true;
		if($scope.board[1][3]==$scope.p2+1 && $scope.board[2][3]==$scope.p2+1 && $scope.board[3][3]==$scope.p2+1)
			return true;

		if($scope.board[1][1]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[3][3]==$scope.p2+1)
			return true;
		if($scope.board[3][1]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[1][3]==$scope.p2+1)
			return true;

		return false;
	}

	$scope.checkWin = function() {
		//console.log($scope.board);

		// Winning move

		if($scope.board[1][1]==2 && $scope.board[1][2]==2 && $scope.board[1][3]==0) return 13;
		if($scope.board[1][1]==2 && $scope.board[1][2]==0 && $scope.board[1][3]==2) return 12;
		if($scope.board[1][1]==0 && $scope.board[1][2]==2 && $scope.board[1][3]==2) return 11;
		
		if($scope.board[2][1]==2 && $scope.board[2][2]==2 && $scope.board[2][3]==0) return 23;
		if($scope.board[2][1]==2 && $scope.board[2][2]==0 && $scope.board[2][3]==2) return 22;
		if($scope.board[2][1]==0 && $scope.board[2][2]==2 && $scope.board[2][3]==2) return 21;
		
		if($scope.board[3][1]==2 && $scope.board[3][2]==2 && $scope.board[3][3]==0) return 33;
		if($scope.board[3][1]==2 && $scope.board[3][2]==0 && $scope.board[3][3]==2) return 32;
		if($scope.board[3][1]==0 && $scope.board[3][2]==2 && $scope.board[3][3]==2) return 31;

		
		if($scope.board[1][1]==2 && $scope.board[2][1]==2 && $scope.board[3][1]==0) return 31;
		if($scope.board[1][1]==2 && $scope.board[2][1]==0 && $scope.board[3][1]==2) return 21;
		if($scope.board[1][1]==0 && $scope.board[2][1]==2 && $scope.board[3][1]==2) return 11;
		
		if($scope.board[1][2]==2 && $scope.board[2][2]==2 && $scope.board[3][2]==0) return 32;
		if($scope.board[1][2]==2 && $scope.board[2][2]==0 && $scope.board[3][2]==2) return 22;
		if($scope.board[1][2]==0 && $scope.board[2][2]==2 && $scope.board[3][2]==2) return 12;
		
		if($scope.board[1][3]==2 && $scope.board[2][3]==2 && $scope.board[3][3]==0) return 33;
		if($scope.board[1][3]==2 && $scope.board[2][3]==0 && $scope.board[3][3]==2) return 23;
		if($scope.board[1][3]==0 && $scope.board[2][3]==2 && $scope.board[3][3]==2) return 13;

		
		if($scope.board[1][1]==2 && $scope.board[2][2]==2 && $scope.board[3][3]==0) return 33;
		if($scope.board[1][1]==2 && $scope.board[2][2]==0 && $scope.board[3][3]==2) return 22;
		if($scope.board[1][1]==0 && $scope.board[2][2]==2 && $scope.board[3][3]==2) return 11;
		
		if($scope.board[3][1]==2 && $scope.board[2][2]==2 && $scope.board[1][3]==0) return 13;
		if($scope.board[3][1]==2 && $scope.board[2][2]==0 && $scope.board[1][3]==2) return 22;
		if($scope.board[3][1]==0 && $scope.board[2][2]==2 && $scope.board[1][3]==2) return 31;

		// Preventing move

		if($scope.board[1][1]==1 && $scope.board[1][2]==1 && $scope.board[1][3]==0) return 13;
		if($scope.board[1][1]==1 && $scope.board[1][2]==0 && $scope.board[1][3]==1) return 12;
		if($scope.board[1][1]==0 && $scope.board[1][2]==1 && $scope.board[1][3]==1) return 11;
		
		if($scope.board[2][1]==1 && $scope.board[2][2]==1 && $scope.board[2][3]==0) return 23;
		if($scope.board[2][1]==1 && $scope.board[2][2]==0 && $scope.board[2][3]==1) return 22;
		if($scope.board[2][1]==0 && $scope.board[2][2]==1 && $scope.board[2][3]==1) return 21;
		
		if($scope.board[3][1]==1 && $scope.board[3][2]==1 && $scope.board[3][3]==0) return 33;
		if($scope.board[3][1]==1 && $scope.board[3][2]==0 && $scope.board[3][3]==1) return 32;
		if($scope.board[3][1]==0 && $scope.board[3][2]==1 && $scope.board[3][3]==1) return 31;

		
		if($scope.board[1][1]==1 && $scope.board[2][1]==1 && $scope.board[3][1]==0) return 31;
		if($scope.board[1][1]==1 && $scope.board[2][1]==0 && $scope.board[3][1]==1) return 21;
		if($scope.board[1][1]==0 && $scope.board[2][1]==1 && $scope.board[3][1]==1) return 11;
		
		if($scope.board[1][2]==1 && $scope.board[2][2]==1 && $scope.board[3][2]==0) return 32;
		if($scope.board[1][2]==1 && $scope.board[2][2]==0 && $scope.board[3][2]==1) return 22;
		if($scope.board[1][2]==0 && $scope.board[2][2]==1 && $scope.board[3][2]==1) return 12;
		
		if($scope.board[1][3]==1 && $scope.board[2][3]==1 && $scope.board[3][3]==0) return 33;
		if($scope.board[1][3]==1 && $scope.board[2][3]==0 && $scope.board[3][3]==1) return 23;
		if($scope.board[1][3]==0 && $scope.board[2][3]==1 && $scope.board[3][3]==1) return 13;

		
		if($scope.board[1][1]==1 && $scope.board[2][2]==1 && $scope.board[3][3]==0) return 33;
		if($scope.board[1][1]==1 && $scope.board[2][2]==0 && $scope.board[3][3]==1) return 22;
		if($scope.board[1][1]==0 && $scope.board[2][2]==1 && $scope.board[3][3]==1) return 11;
		
		if($scope.board[3][1]==1 && $scope.board[2][2]==1 && $scope.board[1][3]==0) return 13;
		if($scope.board[3][1]==1 && $scope.board[2][2]==0 && $scope.board[1][3]==1) return 22;
		if($scope.board[3][1]==0 && $scope.board[2][2]==1 && $scope.board[1][3]==1) return 31;

		return 0;
	}

	$scope.computerTurn = function() {
		//console.log('computer');
		var arr = [];
		var n = 0;
		for($i=1 ; $i<=3 ; $i++)
			for($j=1 ; $j<=3 ; $j++)
				if($scope.board[$i][$j] == 0)
					arr.push($i*10+$j);

		var next = $scope.checkWin();
		//console.log('Check = ' + next);

		if(!next)
			next = arr[Math.floor(Math.random()*(arr.length))];

		setTimeout(function(){ $scope.change(next); }, 250);
	}

	$scope.change = function(rc) {
		$scope.load = true;
		//console.log(rc + ' ' + Math.floor(rc/10) + ' ' + rc%10);
		r = Math.floor(rc/10);
		c = rc%10;

		if($scope.board[r][c] == 0)
		{
			$scope.count++;
			$scope.board[r][c] = $scope.p2 + 1;
			//console.log($scope.board[r][c]);

			if($scope.check())
			{
				setTimeout(function() {
					if($scope.p2==0)
						var wn = "you";
					else
						var wn = "ai";
					$http({
						method : "POST",
						url    : "includes/multi.inc.php?page=upd",
						data   : {
							res : wn,
						}
					}).then(function(data) {
						console.log(data.data);

						if($scope.p2==0 && !$scope.start==0)
							alert('#EeSaalaCupNamde...!! Your turn!');
						else if($scope.p2==0 && !$scope.start==1)
							alert('#EeSaalaCupNamde...!! A.I. starts now.');
						else if($scope.p2==1 && !$scope.start==0)
							alert('#NextSaalaCupNamde...!! Your turn.');
						else if($scope.p2==1 && !$scope.start==1)
							alert('#NextSaalaCupNamde...!! A.I. starts now.');

						if($scope.p2 == 0)
							$scope.w1++;
						else
							$scope.w2++;
						$scope.resetBoard();
						if($scope.p2)
							$scope.computerTurn();
					}, function myError(error) {
						console.log(error);
					});
				}, 1000);
			}
			else if($scope.count == 9)
			{
				$http({
					method : "POST",
					url    : "includes/multi.inc.php?page=upd",
					data   : {
						res : "draw",
					}
				}).then(function(data) {
					console.log(data.data);

					if(!$scope.start==0)
						alert('Match drawn...!! You start now.');
					else
						alert('Match drawn...!! A.I. starts now.');
					$scope.dw++;
					$scope.resetBoard();
					if($scope.p2)
						$scope.computerTurn();
				}, function myError(error) {
					console.log(error);
				});
			}
			else
			{
				$scope.p2 = !$scope.p2;
				if($scope.p2)
					$scope.computerTurn();
			}
			$scope.load = false;
		}
	}

	$scope.reset = function() {
		$scope.init();
	}
	$scope.reset();
});

bodyApp.controller("multiCtrl", function($scope, $http) {

	$scope.resetBoard = function() {
		$scope.board = [
				[0, 0, 0, 0],	
				[0, 0, 0, 0],	
				[0, 0, 0, 0],	
				[0, 0, 0, 0]	
			];
		$scope.count=0;
		$scope.start = !$scope.start;
		$scope.p2 = $scope.start;
	}
	$scope.init1 = function() {
		$scope.D1 = false;
		$scope.id = '';
		$scope.pwd = '';
		$scope.msg = 'Waiting for opponent....';

		$scope.enterD = true;
		$scope.createD = false;
	}

	$scope.enterS = function() {
		$scope.enterD = true;
		$scope.createD = false;
	}
	$scope.createS = function() {
		$scope.enterD = false;
		$scope.createD = true;
	}

	$scope.enter = function() {
		if($scope.rid == '' || $scope.rid == 'undefined' || $scope.pwd == '' || $scope.pwd == 'undefined')
			return;

		$scope.wait = true;
		$http({
			method: "POST",
			url   : "includes/multi.inc.php?page=enter",
			data  : {
				id : $scope.rid,
				pwd: $scope.pwd
			}
		}).then(function(data) {
			console.log(data.data);
			$scope.wait = false;

			if(data.data.room == 'notFound')
				$scope.ridV = true;
			else if(data.data.room == 'notFound')
				$scope.ridF = true;
			else if(data.data.pwd == 'wrng')
				$scope.pwdV = true;
			else if(data.data.status == 'success')
			{
				$scope.init1();
				$scope.init2();
				$scope.D2 = true;
				$scope.waitForMatch();

				$scope.opuname = data.data.uname;

				$http({
					method : "POST",
					url    : "includes/multi.inc.php?page=stats",
					data   : {
						uname : $scope.opuname
					}
				}).then(function(data) {
					console.log(data.data);

					if(data.data.status == 'success')
					{
						$scope.opname = data.data.name;
						$scope.opW = data.data.mw;
						$scope.opL = data.data.ml;
						$scope.opD = data.data.md;

						$scope.msg = "Opponent's move...";
					}
				}, function myError(error) {
					console.log(error);
				});
			}

		}, function myError(error) {
			console.log(error);
		})
	}

	$scope.create = function() {
		if($scope.pwd == '' || $scope.pwd == 'undefined')	return;
		console.log('craeting room');

		$scope.wait = true;
		$http({
			method : "POST",
			url    : "includes/multi.inc.php?page=create",
			data   : {
				pwd : $scope.pwd
			}
		}).then(function(data) {
			console.log(data.data);

			$scope.wait = false;
			if(data.data.status == 'error')
				alert('Oops. Something went wrong.');

			if(data.data.status == 'success')
			{
				$scope.rid = data.data.id;
				
				alert('Your room id is : ' + $scope.rid);

				$scope.init1();
				$scope.init2();
				$scope.D2 = true;
				$scope.p2 = false;

				$scope.wait = true;
				$scope.waitForMatch();
			}

		}, function myError(error) {
			console.log(error);
		})
	}

	$scope.waitForMatch = function() {
		$http({
			method: "POST",
			url   : "includes/multi.inc.php?page=waitForMatch",
			data  : {
				id : $scope.rid
			}
		}).then(function(data) {
			console.log(data.data);

			if(data.data.status == 'success')
			{
				$scope.wait = false;

				$scope.opuname = data.data.id;

				$scope.start = data.data.pid;
				$scope.p2 = data.data.pid;
				$scope.turn = data.data.turn;

				if($scope.p2)
					$scope.waitChange();

				$http({
					method : "POST",
					url    : "includes/multi.inc.php?page=stats",
					data   : {
						uname : $scope.opuname
					}
				}).then(function(data) {
					console.log(data.data);

					if(data.data.status == 'success')
					{
						$scope.opname = data.data.name;
						$scope.opW = data.data.mw;
						$scope.opL = data.data.ml;
						$scope.opD = data.data.md;
						$scope.msg = "Opponent's move...";
					}
				}, function myError(error) {
					console.log(error);
				});
			}
			else if(data.data.status == 'error')
				setTimeout(function() { $scope.waitForMatch() }, 1000);

		}, function myError(error) {
			console.log(error);
		})
	}

	$scope.init2 = function() {
		$scope.p2 = false;
		$scope.D2 = false;
		
		$scope.w1 = 0;
		$scope.w2 = 0;
		$scope.dw = 0;

		$http({
			method : "POST",
			url    : "includes/multi.inc.php?page=stats",
			data   : {
				uname : ''
			}
		}).then(function(data) {
			console.log(data.data);

			if(data.data.status == 'success')
			{
				$scope.uname = data.data.uname;
				$scope.myW = data.data.mw;
				$scope.myL = data.data.ml;
				$scope.mwD = data.data.md;
			}
		}, function myError(error) {
			console.log(error);
		});

		$scope.start = 1;
		$scope.resetBoard();
	}

	$scope.check = function() {
		//console.log($scope.board);
		if($scope.board[1][1]==$scope.p2+1 && $scope.board[1][2]==$scope.p2+1 && $scope.board[1][3]==$scope.p2+1)
			return true;
		if($scope.board[2][1]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[2][3]==$scope.p2+1)
			return true;
		if($scope.board[3][1]==$scope.p2+1 && $scope.board[3][2]==$scope.p2+1 && $scope.board[3][3]==$scope.p2+1)
			return true;

		if($scope.board[1][1]==$scope.p2+1 && $scope.board[2][1]==$scope.p2+1 && $scope.board[3][1]==$scope.p2+1)
			return true;
		if($scope.board[1][2]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[3][2]==$scope.p2+1)
			return true;
		if($scope.board[1][3]==$scope.p2+1 && $scope.board[2][3]==$scope.p2+1 && $scope.board[3][3]==$scope.p2+1)
			return true;

		if($scope.board[1][1]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[3][3]==$scope.p2+1)
			return true;
		if($scope.board[3][1]==$scope.p2+1 && $scope.board[2][2]==$scope.p2+1 && $scope.board[1][3]==$scope.p2+1)
			return true;

		return false;
	}

	$scope.waitChange = function() {
		console.log('Fetching move');
		$scope.wait = true;

		$http({
			method: "POST",
			url   : "includes/multi.inc.php?page=waitChange",
			data  : {
				id : $scope.rid,
				start : $scope.start
			}
		}).then(function(data) {
			console.log(data.data);

			if(data.data.status == "success")
			{
				var rc = data.data.move;

				r = Math.floor(rc/10);
				c = rc%10;

				$scope.count++;
				$scope.board[r][c] = $scope.p2 + 1;

				$scope.wait = false;

				if($scope.check())
				{
					setTimeout(function() {
						if($scope.p2==0)
							var wn = "you";
						else
							var wn = "ai";

						if($scope.p2==0 && !$scope.start==0)
							alert('#EeSaalaCupNamde...!! Your turn!');
						else if($scope.p2==0 && !$scope.start==1)
							alert('#EeSaalaCupNamde...!! ' + $scope.opuname + ' starts now.');
						else if($scope.p2==1 && !$scope.start==0)
							alert('#NextSaalaCupNamde...!! Your turn.');
						else if($scope.p2==1 && !$scope.start==1)
							alert('#NextSaalaCupNamde...!! ' + $scope.opuname + ' starts now.');

						if($scope.p2 == 0)
							$scope.w1++;
						else
							$scope.w2++;
						$scope.resetBoard();
						if($scope.p2)
							$scope.waitChange();
					}, 1000);
				}
				else if($scope.count == 9)
				{
					if(!$scope.start==0)
						alert('Match drawn...!! Your turn.');
					else
						alert('Match drawn...!! ' + $scope.opuname + ' starts now.');
					$scope.dw++;
					$scope.resetBoard();
					if($scope.p2)
						$scope.waitChange();
				}
				else
					$scope.p2 = !$scope.p2;
			}
			else
				setTimeout(function() { $scope.waitChange(); }, 1000);

		}, function myError(error) {
			console.log(error);
		});
	}

	$scope.change = function(rc) {
		$scope.wait = true;
		//console.log(rc + ' ' + Math.floor(rc/10) + ' ' + rc%10);
		r = Math.floor(rc/10);
		c = rc%10;

		if($scope.board[r][c] == 0)
		{
			$scope.count++;
			$scope.board[r][c] = $scope.p2 + 1;
			//console.log($scope.board[r][c]);

			$http({
				method: "POST",
				url   : "includes/multi.inc.php?page=makeChange",
				data  : {
					id : $scope.rid,
					move : rc
				}
			}).then(function(data) {
				console.log(data.data);

				if($scope.check())
				{
					setTimeout(function() {
						if($scope.p2==0)
							var wn = "you";
						else
							var wn = "ai";
						$http({
							method : "POST",
							url    : "includes/multi.inc.php?page=Mupd",
							data   : {
								res : wn,
								id : $scope.rid
							}
						}).then(function(data) {
							console.log(data.data);

							if($scope.p2==0 && !$scope.start==0)
								alert('#EeSaalaCupNamde...!! Your turn!');
							else if($scope.p2==0 && !$scope.start==1)
								alert('#EeSaalaCupNamde...!! ' + $scope.opuname + ' starts now.');
							else if($scope.p2==1 && !$scope.start==0)
								alert('#NextSaalaCupNamde...!! Your turn.');
							else if($scope.p2==1 && !$scope.start==1)
								alert('#NextSaalaCupNamde...!! ' + $scope.opuname + ' starts now.');

							if($scope.p2 == 0)
								$scope.w1++;
							else
								$scope.w2++;
							$scope.resetBoard();

							if($scope.p2)
								$scope.waitChange();
						}, function myError(error) {
							console.log(error);
						});
					}, 1000);
				}
				else if($scope.count == 9)
				{
					setTimeout(function() {
						$http({
							method : "POST",
							url    : "includes/multi.inc.php?page=Mupd",
							data   : {
								res : "draw",
								id : $scope.rid
							}
						}).then(function(data) {
							console.log(data.data);

							if(!$scope.start==0)
								alert('Match drawn...!! Your turn.');
							else
								alert('Match drawn...!! ' + $scope.opuname + ' starts now.');
							$scope.dw++;
							$scope.resetBoard();
							if($scope.p2)
								$scope.waitChange();
						}, function myError(error) {
							console.log(error);
						});
					}, 1000);
				}
				else
				{
					$scope.p2 = !$scope.p2;
					if($scope.p2)
						$scope.waitChange();
				}
				$scope.wait = false;

			}, function myError(error) {
				console.log(error);
			});
		}
	}

	$scope.reset = function() {
		$scope.init1();
		$scope.D1 = true;
	}
	$scope.reset();
});