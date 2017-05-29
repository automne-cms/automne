// TODO: refactor away duplicationg in DragSort and DragSortX
/*
 *$Id: dragsort.js,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $
 */

var BetterDragSort = {

	makeListSortable : function(list) {
    	var items = list.getElementsByTagName("li");

		for (var i = 0; i < items.length; i++) {
			BetterDragSort.makeItemSortable(items[i]);
		}
	},

	makeItemSortable : function(item) {
		Drag.makeDraggable(item);
		item.setDragThresholdY(5);

		item.onDragStart = BetterDragSort.onDragStart;
		item.onDrag = BetterDragSort.onDrag;
		item.onDragEnd = BetterDragSort.onDragEnd;
	},

	onDragStart : function(nwPosition, sePosition, nwOffset, seOffset) {
		var items = this.parentNode.getElementsByTagName("li");
		var minOffset = Coordinates.northwestOffset(items[0], true);
		var maxOffset = minOffset;
		for (var i = 0; i < items.length; i++) {
			maxOffset = maxOffset.max(Coordinates.northwestOffset(items[i], true));
		}
		this.constrain(minOffset, maxOffset);
	},

	onDrag : function(nwPosition, sePosition, nwOffset, seOffset) {
		var swapper = null;

		var next = DragUtils.nextItem(this);
		while (next != null) {
			var nextNWOffset = Coordinates.northwestOffset(next, true);
			var nextSEOffset = Coordinates.southeastOffset(next, true);

			if (nwOffset.y >= (nextNWOffset.y - 2) &&
					nwOffset.y <= (nextSEOffset.y + 2) &&
					nwOffset.x >= (nextNWOffset.x - 2) &&
					nwOffset.x <= (nextSEOffset.x + 2)) {
				var swapper = next;
				break;
			} 
			var next = DragUtils.nextItem(next);
		}
		if (swapper != null) {
			BetterDragSort.moveAfter(this, swapper);
			return;
		}

		var previous = DragUtils.previousItem(this);
		while (previous != null) {
			var previousNWOffset = Coordinates.northwestOffset(previous, true);
			var previousSEOffset = Coordinates.southeastOffset(previous, true);

			var fudgeFactor = 2;
			if (nwOffset.y >= (previousNWOffset.y - fudgeFactor) &&
					nwOffset.y <= (previousSEOffset.y + fudgeFactor) &&
					nwOffset.x >= (previousNWOffset.x - fudgeFactor) &&
					nwOffset.x <= (previousSEOffset.x + fudgeFactor)) {
				var swapper = previous;
				break;
			} 
			var previous = DragUtils.previousItem(previous);
		}
		if (swapper != null) {
			BetterDragSort.moveBefore(this, swapper);
			return;
		}
	},

	moveAfter : function(item1, item2) {
		var parent = item1.parentNode;
		parent.removeChild(item1);
		parent.insertBefore(item1, item2.nextSibling);

		item1.style["top"] = "0px";
		item1.style["left"] = "0px";
	},

	moveBefore : function(item1, item2) {
		var parent = item1.parentNode;
		parent.removeChild(item1);
		parent.insertBefore(item1, item2);

		item1.style["top"] = "0px";
		item1.style["left"] = "0px";
	},

	onDragEnd : function(nwPosition, sePosition, nwOffset, seOffset) {
		this.style["top"] = "0px";
		this.style["left"] = "0px";
	}
};


var DragSort = {

	makeListSortable : function(list) {
    	var items = list.getElementsByTagName("li");

		for (var i = 0; i < items.length; i++) {
			DragSort.makeItemSortable(items[i]);
		}
	},

	makeItemSortable : function(item) {
		Drag.makeDraggable(item);
		item.setDragThresholdY(5);

		item.onDragStart = DragSort.onDragStart;
		item.onDrag = DragSort.onDrag;
		item.onDragEnd = DragSort.onDragEnd;
	},

	onDragStart : function(nwPosition, sePosition, nwOffset, seOffset) {
		var items = this.parentNode.getElementsByTagName("li");
		var minOffset = Coordinates.northwestOffset(items[0], true);
		var maxOffset = Coordinates.northwestOffset(items[items.length - 1], true);
		this.constrain(minOffset, maxOffset);
	},

	onDrag : function(nwPosition, sePosition, nwOffset, seOffset) {
		var parent = this.parentNode;

		var item = this;
		var next = DragUtils.nextItem(item);
		while (next != null && this.offsetTop >= next.offsetTop - 2) {
			var item = next;
			var next = DragUtils.nextItem(item);
		}
		if (this != item) {
			DragUtils.swap(this, next);
			return;
		}

		var item = this;
		var previous = DragUtils.previousItem(item);
		while (previous != null && this.offsetTop <= previous.offsetTop + 2) {
			var item = previous;
			var previous = DragUtils.previousItem(item);
		}
		if (this != item) {
			DragUtils.swap(this, item);
			return;
		}
	},

	onDragEnd : function(nwPosition, sePosition, nwOffset, seOffset) {
		this.style["top"] = "0px";
		this.style["left"] = "0px";
		/*modified for Automne*/
		if (typeof stopDragging == "function") {
			stopDragging(this.id);
		}
	}
};

var DragSortX = {

	makeListSortable : function(list) {
    	var items = list.getElementsByTagName("li");

		var minOffset = Coordinates.northwestOffset(items[0], true);
		var maxOffset = Coordinates.northwestOffset(items[items.length - 1], true);

		for (var i = 0; i < items.length; i++) {
			Drag.makeDraggable(items[i]);
			items[i].constrain(minOffset, maxOffset);
			items[i].setDragThresholdX(5);

			items[i].onDrag = DragSortX.onDrag;

			items[i].onDragEnd = function(nwPosition, sePosition, nwOffset, seOffset) {
				this.style["top"] = "0px";
				this.style["left"] = "0px";
			};
		}
	},

	onDrag : function(nwPosition, sePosition, nwOffset, seOffset) {
		var parent = this.parentNode;

		var item = this;
		var next = DragUtils.nextItem(item);
		while (next != null && this.offsetLeft >= next.offsetLeft - 2) {
			var item = next;
			var next = DragUtils.nextItem(item);
		}
		if (this != item) {
			DragUtils.swap(this, next);
			return;
		}

		var item = this;
		var previous = DragUtils.previousItem(item);
		while (previous != null && this.offsetLeft <= previous.offsetLeft + 2) {
			var item = previous;
			var previous = DragUtils.previousItem(item);
		}
		if (this != item) {
			DragUtils.swap(this, item);
			return;
		}
	}
};

var DragUtils = {
	swap : function(item1, item2) {
		var parent = item1.parentNode;
		parent.removeChild(item1);
		parent.insertBefore(item1, item2);

		item1.style["top"] = "0px";
		item1.style["left"] = "0px";
		/*modified for Automne*/
		if (typeof startDragging == "function") {
			startDragging();
		}
	},

	nextItem : function(item) {
		var sibling = item.nextSibling;
		while (sibling != null) {
			if (sibling.nodeName == item.nodeName) return sibling;
			sibling = sibling.nextSibling;
		}
		return null;
	},

	previousItem : function(item) {
		var sibling = item.previousSibling;
		while (sibling != null) {
			if (sibling.nodeName == item.nodeName) return sibling;
			sibling = sibling.previousSibling;
		}
		return null;
	}
};
