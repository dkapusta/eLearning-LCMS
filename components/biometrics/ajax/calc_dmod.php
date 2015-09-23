<?php

function userHasPDMOD($userId, $type) {
	if (!hasPositiveDMOD($userId)) {
		makeDmod($userId, 'positive', 'create');
	}
}

function checkIfUserHasEnoughNegative($userId) {
	$count = getNumNegatives($userId);

	if ($count > 14) {
		if (userNeedsNegatives($userId)) {
		    removeFromRequireNegativesList($userId);
		}

		if (!hasNegativeDMOD($userId)) {
		    makeDMOD($userId, 'negative', 'create');
		}
		return true;
	}

	return false;
}