/** For rendering predictions using react **/
var CompetitionSelect = React.createClass({
    
    propTypes: {
        url: React.PropTypes.string.isRequired
    },
    getInitialState: function() {
        return {
            options: []
        }
    },
    componentDidMount: function() {
        console.log("TEST");
        // get your data
        $.ajax({
            url: this.props.url,
            success: this.successHandler
        })
    },
    successHandler: function(data) {
        // assuming data is an array of {name: "foo", value: "bar"}
        for (var i = 0; i < data.length; i++) {
            var option = data[i];
            this.state.options.push(
                <option key={i} value={option.id}>{option.name}</option>
            );
        }
        this.forceUpdate();
    },
    render: function() {
        return this.transferPropsTo(
            <select>{this.state.options}</select>
        )
    }
});
/**
var CompetitionSelect = React.createClass({
  
  loadPredictionsFromServer: function() {
    $.ajax({
      url: 'api/competitions',
      dataType: 'json',
      cache: false,
      success: function(data) {
        this.setState({data: data});
      }.bind(this),
      error: function(xhr, status, err) {
        console.error(this.props.url, status, err.toString());
      }.bind(this)
    });
  },
  
  Render: function() {
    var competitionsNodes = this.props.data.map(function(competition) {
      return (
        <option value={competition.id}> {competition.name} </option>
      );
    });
    
    return (
      <div className="competitionSelect" >
        <select name="competition">
          {competitionNodes}
        </select>
      </div>
    );
  }
  
});
**/

var PredictionBox = React.createClass({
  /*
  loadPredictionsFromServer: function() {
    $.ajax({
      url: 'api/competitions',
      dataType: 'json',
      cache: false,
      success: function(data) {
        this.setState({data: data});
      }.bind(this),
      error: function(xhr, status, err) {
        console.error(this.props.url, status, err.toString());
      }.bind(this)
    });
  },
  */
  
  getInitialState: function() {
        return {
            childSelectValue: undefined
        }
  },
  changeHandler: function(e) {
      this.setState({
          childSelectValue: e.target.value
      })
  },
  render: function() {
      console.log("test");
      return (
          <div className="predictionBox">
              <h1>Predictions</h1>
              <CompetitionSelect 
                  url="api/competitions"
                  value={this.state.childSelectValue}
                  onChange={this.changeHandler} 
              />
          </div>
      )
  }
  
});

/**
var FootballPrediction = React.createClass({
    
  getInitialState: function() {
    return {homescore: this.props.homescore, awayscore: this.props.awayscore};
  },
  
  handleHomeScoreChange: function(e) {
    this.setState({homescore: e.target.value});
    
    var homeScore = this.state.homescore.trim();
    var awayScore = this.state.awayscore.trim();
    if (!homeScore || !awayScore) {
      return;
    }
    this.props.onPredictionSubmit({homescore: awayScore, awayscore: awayScore});
    
  },
  
  handleAwayScoreChange: function(e) {
    this.setState({awayscore: e.target.value});
    
    var homeScore = this.state.homescore.trim();
    var awayScore = this.state.awayscore.trim();
    if (!homeScore || !awayScore) {
      return;
    }
    this.props.onPredictionSubmit({homescore: awayScore, awayscore: awayScore});
  },

  render: function() {
    return (
      <div className="prediction panel panel-default" >
        <div className="panel-heading">
            <h2 className="eventdate">
              {this.props.date}
            </h2>
        </div>
        <div className="panel-body">
            <form className="predictionForm" onSubmit={this.handleSubmit}>
            <div className="row">
                <h2 className="eventname">
                    {this.props.eventname}
                </h2>
            </div>
            <div className="row">
                <input
                    type="integer"
                    placeholder="0"
                    value={this.props.homescore}
                    onChange={this.handleHomeScoreChange}
                />
                <input
                    type="integer"
                    placeholder="0"
                    value={this.props.awayscore}
                    onChange={this.handleHomeScoreChange}
                />
            </div>
        </div>
        <div className="panel-footer">
            <h2 className="eventnote">
              {this.props.eventnote}
        </div>
      </div>
    );
  }
});

var PredictionGroup = react.createClass({

  render: function() {
    
  }

});

var PredictionBox = react.createClass({

    loadPredictionsFromServer: function() {
      $.ajax({
        url: 'api/predictions',
        dataType: 'json',
        cache: false,
        success: function(data) {
          this.setState({data: data});
        }.bind(this),
        error: function(xhr, status, err) {
          console.error(this.props.url, status, err.toString());
        }.bind(this)
      });
    },
    
    loadGroupsFromServer: function() {
      $.ajax({
        url: 'api/groups',
        dataType: 'json',
        cache: false,
        success: function(data) {
          this.setState({data: data});
        }.bind(this),
        error: function(xhr, status, err) {
          console.error(this.props.url, status, err.toString());
        }.bind(this)
      });
    },
    }
  
    getInitialState: function() {
      return {data: []};
    },
    componentDidMount: function() {
      this.loadCommentsFromServer();
      setInterval(this.loadCommentsFromServer, this.props.pollInterval);
    },
  render: function() {
    return (
      <div className="commentBox">
        <h1>Comments</h1>
        <CommentList data={this.state.data} />
        <CommentForm onCommentSubmit={this.handleCommentSubmit} />
      </div>
    );
  }
});


});

**/

console.log("running");

ReactDOM.render(
  <PredictionBox />,
  document.getElementById('content')
);