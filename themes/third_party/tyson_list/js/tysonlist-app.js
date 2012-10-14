var TaskItem = function(data) {
	var self = this;
	
	if(typeof(data) != "undefined") {
		self.taskName = ko.observable(data.taskName);
		self.isComplete = ko.observable(data.isComplete);

		self.editMode = ko.observable(data.editMode);
	} else {
		self.taskName = ko.observable("");
		self.isComplete = ko.observable(false);

		self.editMode = ko.observable(false);
	}
	
}

var TaskList = function(data) {
	var self = this;

	if(typeof(data) != "undefined") {
		self.listName = ko.observable(data.listName);
		self.taskItems = ko.observableArray([]);

		if(typeof(data.taskItems) != 'undefined' ) {
			for(task in data.taskItems) {
				self.taskItems.push(new TaskItem(task));
			}
		}

		self.editMode = ko.observable(data.editMode);
	} else {
		self.listName = ko.observable("");
		self.taskItems = ko.observableArray([]);

		self.editMode = ko.observable(false);
	}
	
}

var TysonListViewModel = function () {
	var self = this;
	
	self.taskLists = ko.observableArray([]);
	
	self.chosenListName = ko.observable();
	self.chosenList = ko.observable();
	
	
	self.newTaskDetail = ko.observable();

	//behaviours 
	self.goToList = function(list) {
		self.chosenList(list);
	};
	
	self.enableEdit = function() {
		self.chosenList().editMode(true);
	};
	
	self.finishEdit = function() {
		self.chosenList().editMode(false);
	}
	
	self.newTaskItem = function() {
		self.chosenList().taskItems.push(new TaskItem({taskName:self.newTaskDetail(), isComplete:false, editMode:false}));
		self.newTaskDetail("");
	}
	
	self.editTask = function(task) {
		task.editMode(true);
	}
	
	self.finishEditTask = function(task) {
		task.editMode(false);
	}
	
	self.removeTask = function(task) {
		self.chosenList().taskItems.remove(task);
	}
	
	self.newList = function() {
		var list = new TaskList({listName:"New List", editMode:true});
		if(self.taskLists() == null)
			self.taskLists = ko.observableArray([]);
			
		self.taskLists.push(list);
		self.chosenList(list);
	}
	
	self.deleteList = function() {
		self.taskLists.remove(self.chosenList());
		self.chosenList(null);
	}
	
	self.saveLists = function() {
		var data = {
			list_data : ko.mapping.toJSON(self.taskLists)
		};
		
		api_saveList(data, function(return_data) {
			//nothing yet
		});
	}
	
	self.loadLists = function() {
		api_getLists(function(return_data) {
			if(return_data != null && return_data != "") {
				self.taskLists(ko.mapping.fromJSON(return_data));
				
				if(self.taskLists() != null && self.taskLists().length > 0)
					self.chosenList(self.taskLists()[0]);
					
			}
		});
	}
	
	this.loadLists();
}

function api_saveList(list_data, successCallback) {
	var url = ACT_URL + TysonApi.SAVE_LISTS;
	$.ajax({
		type: "POST",
	  	url: url,
	  	data: list_data,
	  	dataType : 'json',
	  	success: successCallback,
	  	error: function(XMLHttpRequest, textStatus, errorThrown) {
	     	alert(errorThrown);
	  	}
	});
}

function api_getLists(successCallback) {
	var url = ACT_URL + TysonApi.GET_LISTS;
	$.ajax({
		type: "POST",
	  	url: url,
	  	dataType : 'text',
	  	success: successCallback,
	  	error: function(XMLHttpRequest, textStatus, errorThrown) {
	     	alert(errorThrown);
	  	}
	});
}


var viewModel = new TysonListViewModel();
ko.applyBindings(viewModel);