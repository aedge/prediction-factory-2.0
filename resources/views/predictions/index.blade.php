@extends('layouts.app')

@section('content')

<div id="content">
    <div id="divSelect" class="well" >
        
        <label for"selCompetition">Competition</label>
        <select id="selCompetition" 
                data-bind="options: competitions,
                           optionsText: 'name',
                           optionsValue: 'id',
                           value: selectedCompetition"
                           class="form-control" ></select>
        <label for"selGroup">Group</label>
        <select id="selGroup"
                data-bind="options: groups,
                           optionsText: 'name',
                           optionsValue: 'id',
                           value: selectedGroup"
                           class="form-control" ></select>
                           
                                   
                           
    </div>
    
    <div data-bind="foreach: predictionRows">
        <div class="row" data-bind="foreach: $data" >
            <div class="col-md-4" >
                <div data-bind="if: footballmatch">
                    <footballmatch-prediction params="event: $data"></footballmatch-prediction>
                </div>
                <div data-bind="if: textbox">
                    <textbox-prediction params="event: $data"></textbox-prediction>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-scripts')

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function PredictionPageViewModel() {

        var self = this;
        self.competitions = ko.observableArray();
        self.selectedCompetition = ko.observable();
        self.groups = ko.observableArray();
        self.selectedGroup = ko.observable();
        //self.predictions = ko.observableArray();
        self.predictionRows = ko.observableArray();
        
        self.loadGroups = function(competitionId) {
            if (typeof competitionId !== 'undefined') {
                $.getJSON("/api/groups/" + competitionId, function(data) { 
                        self.groups([]);
                        $.each( data, function( i, item ) {
                            self.groups.push(item);
                            if(i == 0){
                                self.selectedGroup(item.id);
                            }
                        });
                });
            }
        };
        
        self.loadCompetitions = function() {  
            $.getJSON("/api/competitions", function(data) { 
                $.each( data, function( i, item ) {
                    self.competitions.push(item);
                    if(i == 0){
                    self.selectedCompetition(item.id);
                    }
                });
            });
        };
        
        self.loadPredictions = function(groupId) {
            if (typeof groupId !== 'undefined') {
                $.getJSON("/api/events/" + groupId, function(data) { 
                        var predictions = [];
                        self.predictionRows([]);
                        $.each( data, function( i, item ) {
                            
                            if(item.type == "footballmatch") 
                            {
                                item.footballmatch = true;
                                item.textbox = false;
                            }
                            else if(item.type == "textbox") 
                            {
                                item.textbox = true;
                                item.footballmatch = false;
                            }
                            predictions.push(item);
                            if (((i + 1) % 3) === 0) {
                                self.predictionRows.push(predictions);
                                predictions = [];
                            }
                        });
                        self.predictionRows.push(predictions);
                });
            }
        }
        
        
        self.groupsTrigger = ko.computed(function () {
                        return self.loadGroups(self.selectedCompetition());           
                     }, this);
                     
        self.predictionsTrigger = ko.computed(function () {
                        return self.loadPredictions(self.selectedGroup());           
                     }, this);
                     
        self.predictionsChangeTrigger
                     
        self.loadCompetitions();
    }
    
    ko.components.register('footballmatch-prediction', {
        viewModel: function(params) {
            var self = this;
            var event = params.event;
            self.id   = event.id;
            self.date = ko.observable(event.date);
            self.hometeam = ko.observable(event.hometeam);
            self.awayteam = ko.observable(event.awayteam);
            self.homescore = ko.observable(event.homescore);
            self.awayscore = ko.observable(event.awayscore);
            self.disabled  = ko.observable(event.disabled);
            self.points    = ko.observable(event.points + " points");
            /**
            self.homescore.subscribe(function(newValue) {
                console.log(self.homescore() + " " + self.awayscore() + " " + self.result());
                var data = ko.toJSON(self);
                $.ajax("/api/prediction", {
                    data: data,
                    type: "post", contentType: "application/json",
                    success: function(result) {  }
                });
            });
            
            self.awayscore.subscribe(function(newValue) {
                var data = ko.toJSON(self);
                $.ajax("/api/prediction", {
                    data: data,
                    type: "post", contentType: "application/json",
                    success: function(result) {  }
                });
            });
            **/
            
            self.result = ko.computed(function() {
                            if(self.homescore() == self.awayscore()){
                                return 'draw';
                            }
                            else if (self.homescore() > self.awayscore()){
                                return 'homewin';
                            }
                            else if (self.homescore() < self.awayscore()){
                                return 'awaywin';
                            }
                            }, this);
                        
            self.textResult = ko.computed(function() {
                                return self.homescore() + " - " + self.awayscore();
                                }, this);
                                
            self.textResult.subscribe(function(newValue) {
                var data = ko.toJSON(self);
                $.ajax("/api/prediction", {
                    data: data,
                    type: "post", contentType: "application/json",
                    success: function(result) {  }
                });
            });
         
        },
        template:
            '<div class="panel panel-default text-center" >\
                <div class="panel-heading" data-bind="text: date"></div>\
                <div class="panel-body">\
                    <div class="col-xs-4"><h4 data-bind="text: hometeam"></h4></div>\
                    <div class="col-xs-2" style="padding-left:0px;padding-right:5px;" ><input type="number" class="form-control" data-bind="value: homescore, bootstrapDisabled: disabled"  /></div>\
                    <div class="col-xs-2" style="padding-right:0px;padding-left:5px;" ><input type="number" class="form-control" data-bind="value: awayscore, bootstrapDisabled: disabled"  /></div>\
                    <div class="col-xs-4"><h4 data-bind="text: awayteam"></h4></div>\
                </div>\
                <div class="panel-footer" data-bind="text: points, visible: disabled"></div>\
            </div>'
    });
    
    ko.components.register('textbox-prediction', {
        viewModel: function(params) {
            var self = this;
            event = params.event;
            self.id   = event.id;
            self.date = ko.observable(event.date);
            self.name = ko.observable(event.name);
            self.text = ko.observable(event.text);
            self.disabled  = ko.observable(event.disabled);
            self.points  = ko.observable(event.points + " points");
            
            self.text.subscribe(function(newValue) {
                var data = ko.toJSON(self);
                $.ajax("/api/prediction", {
                    data: data,
                    type: "post", contentType: "application/json",
                    success: function(result) {  }
                });
            });
            
        },
        template:
            '<div class="panel panel-default text-center" >\
                <div class="panel-heading" data-bind="text: date"></div>\
                    <div class="panel-body">\
                        <h4 data-bind="text: name"></h4>\
                        <input type="text" id="txtName" class="form-control" data-bind="value: text, bootstrapDisabled: disabled" />\
                    </div>\
                <div class="panel-footer" data-bind="text: points, visible: disabled"></div>\
                </div>'
                
        });
        
    ko.bindingHandlers.bootstrapDisabled = {
        init: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            var value = ko.unwrap(valueAccessor());
            
            // Now manipulate the DOM element
            if (value == "true")
                $(element).attr( "disabled", "true" ); // Make the element disabled
            else
                $(element).removeAttr( "disabled" );   // remove disabled attribute
        },
        update: function(element, valueAccessor, allBindings, viewModel, bindingContext) {
            // First get the latest data that we're bound to
            var value = valueAccessor();
     
            // Next, whether or not the supplied model property is observable, get its current value
            var valueUnwrapped = ko.unwrap(value);
            
            // Now manipulate the DOM element
            if (valueUnwrapped == "true")
                $(element).attr( "disabled", "true" ); // Make the element disabled
            else
                $(element).removeAttr( "disabled" );   // remove disabled attribute
        }
    };
    
    ko.applyBindings(new PredictionPageViewModel());
    
</script>

<!--<script src="/js/predictionsKO.js" type="text/javascript"></script>-->

@endsection