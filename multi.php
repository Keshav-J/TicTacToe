<?php

include_once 'header.php';

if(!isset($_SESSION['uname'])) {
?>
	<script>
		alert('You need to be logged in to play multiplayer.');
		window.location.href = 'index.php';
	</script>
<?php
}

?>

<style>
	.two {
		width: 300px;
		height: 300px;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		position: absolute;
	}

	.two table {
		width: 300px;
		height: 300px;
		text-align: center;
		background: url(img/bg5.jpg);
		-webkit-transition: all 1s ease-in-out;
		padding: 0px;
		table-layout: fixed;
	}

	.two table td {
		height: 100px;
		width: 100px;
		padding: 0px;
	}

	.two table td label {
		cursor: pointer;
		width: 100px;
		height: 100px;
		display: inline-block;
		padding: 0px;
		margin: 0px;
	}

	.x {
		background: url(img/x.png) no-repeat center center;
	}
	.o {
		background: url(img/o.png) no-repeat center center;
	}

	.player {
		width: 99%;
		height: -webkit-fill-available;
		position: fixed;
		float: left;
	}

	.play {
		float: left;
		width: 50%;
		height: -webkit-fill-available;
		transform: translate(0, 45%);
	}

	.play label {
		padding: 15px;
		font-family: Comic Sans MS;
		font-size: 25px;
		font-weight: bold;
		color: #000000;
	}
	.play .active {
		-webkit-transition: all 0.30s ease-in-out;
		text-shadow: 0 0 5px rgb(76, 2, 255);
	}
</style>

<div class="twoDiv" ng-controller="multiCtrl">

	<div class="pre-loader" ng-show="wait" style="background-color: rgba(255, 255, 255, 0.3);">
		<div class="pre-ele fontDec">
			<div class="pre-text">
				{{ msg }}
			</div>
		</div>
	</div>

	<div class="loginDiv" ng-show="D1">
		<div class="container">
			<div class="close">
			</div>
			<div style="background-color:white; padding:5px; border-radius:2px;">
				<div class="nav">
					<input class="navEle left center" type="radio" name="tabs" id="tab3" ng-click="enterS()" checked>
					<label class="navEle left center" for="tab3" style="width: 50%"> Enter </label>
					<input class="navEle right center" type="radio" name="tabs" id="tab4" ng-click="createS()">
					<label class="navEle right center" for="tab4" style="width: 50%"> Create </label>
				</div>
				<hr>
				<br>
				<div ng-show="enterD">
					<form>
						<input class="inp" type="text" ng-model="rid" placeholder="Room id" required>
						<br ng-show="ridV"><span style="color: red;" ng-show="ridV">Room id Not Found.</span>
						<br ng-show="ridF"><span style="color: red;" ng-show="ridF">Room is Full.</span>
						<br><br>
						<input class="inp" type="password" ng-model="pwd" placeholder="Password" required>
						<br ng-show="pwdV"><span style="color: red;" ng-show="pwdV">Password does not match.</span>
						<br><br>
						<input class="btn" style="background-color: #D83F3B;" type="submit" ng-click="enter()" value="Enter">
						<br><br>
					</form>
				</div>
				<div ng-show="createD">
					<form method="POST">
						<span style="color: red;">Room id will be given.</span>
						<br><br>
						<input class="inp" type="password" ng-model="pwd" placeholder="Password" required>
						<br><br>
						<input class="btn" style="background-color: #D83F3B;" type="submit" ng-click="create()" value="Create">
						<br><br>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div ng-show="D2">

		<div class="player center">
			<div class="play">
				<label ng-show="p2"> {{ uname }} </label>
				<label ng-show="!p2" class="active"> {{ uname }} </label>

				<br>
				<label style="font-size: 45px;"> {{ w1 }} </label>
			</div>

			<div class="play">
				<label ng-show="p2" class="active"> {{ opuname }} </label>
				<label ng-show="!p2"> {{ opuname }} </label>

				<br>
				<label style="font-size: 45px;"> {{ w2 }} </label>
			</div>
	 	</div>

		<div class="two">

			<table cellpadding="0" cellspacing="0" ng-disabled="true">
				<colgroup>
					<col width="100px">
					<col width="100px">
					<col width="100px">
				</colgroup>
				
				<tr>
					<td ng-show="board[1][1]==0"> <label ng-click="change(11)">&nbsp</label> </td>
					<td class="x" ng-show="board[1][1]==1"></td>
					<td class="o" ng-show="board[1][1]==2"></td>
					
					<td ng-show="board[1][2]==0"> <label ng-click="change(12)">&nbsp</label> </td>
					<td class="x" ng-show="board[1][2]==1">	</td>
					<td class="o" ng-show="board[1][2]==2">	</td>
					
					<td ng-show="board[1][3]==0"> <label ng-click="change(13)">&nbsp</label> </td>
					<td class="x" ng-show="board[1][3]==1">	</td>
					<td class="o" ng-show="board[1][3]==2">	</td>
				</tr>
				
				<tr>
					<td ng-show="board[2][1]==0"> <label ng-click="change(21)">&nbsp</label> </td>
					<td class="x" ng-show="board[2][1]==1"></td>
					<td class="o" ng-show="board[2][1]==2"></td>
					
					<td ng-show="board[2][2]==0"> <label ng-click="change(22)">&nbsp</label> </td>
					<td class="x" ng-show="board[2][2]==1">	</td>
					<td class="o" ng-show="board[2][2]==2">	</td>
					
					<td ng-show="board[2][3]==0"> <label ng-click="change(23)">&nbsp</label> </td>
					<td class="x" ng-show="board[2][3]==1">	</td>
					<td class="o" ng-show="board[2][3]==2">	</td>
				</tr>

				<tr>
					<td ng-show="board[3][1]==0"> <label ng-click="change(31)">&nbsp</label> </td>
					<td class="x" ng-show="board[3][1]==1"></td>
					<td class="o" ng-show="board[3][1]==2"></td>
					
					<td ng-show="board[3][2]==0"> <label ng-click="change(32)">&nbsp</label> </td>
					<td class="x" ng-show="board[3][2]==1">	</td>
					<td class="o" ng-show="board[3][2]==2">	</td>
					
					<td ng-show="board[3][3]==0"> <label ng-click="change(33)">&nbsp</label> </td>
					<td class="x" ng-show="board[3][3]==1">	</td>
					<td class="o" ng-show="board[3][3]==2">	</td>
				</tr>
			</table>
			
			<div class="center" style="padding:15px; font-family:Comic Sans MS; font-size:25px; font-weight:bold; color: #000000;">
				<label> Draw </label>
				<br>
				<label style="font-size: 45px;"> {{ dw }} </label>
				
			</div>
		</div>

		<div class="two" ng-show="p2">
			
		</div>
	</div>

</div>

<script>

</script>

<?php

include_once 'footer.php';

?>