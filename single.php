<?php

include_once 'header.php';

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

<div class="twoDiv" ng-controller="singleCtrl">

	<div class="player center">
		<div class="play">
			<label ng-show="p2"> {{ uname }} </label>
			<label ng-show="!p2" class="active"> {{ uname }} </label>

			<br>
			<label style="font-size: 45px;"> {{ w1 }} </label>
		</div>

		<div class="play">
			<label ng-show="p2" class="active"> A. I. </label>
			<label ng-show="!p2"> A. I. </label>

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

<script>

</script>

<?php

include_once 'footer.php';

?>