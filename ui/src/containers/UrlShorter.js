import React, { Component } from 'react';
import injectTapEventPlugin from 'react-tap-event-plugin';
import { sendUrl } from '../api';

// Material UI
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import getMuiTheme from 'material-ui/styles/getMuiTheme';
import lightBaseTheme from 'material-ui/styles/baseThemes/lightBaseTheme';

import Paper from 'material-ui/Paper';
import TextField from 'material-ui/TextField';
import Divider from 'material-ui/Divider';
import RaisedButton from 'material-ui/RaisedButton';

const lightMuiTheme = getMuiTheme(lightBaseTheme);

const style = {
  marginLeft: 20
};

function absoluteUrl() {
  return window.location.toString();
}

class UrlShorter extends Component {
  constructor(props) {
    injectTapEventPlugin();
    super(props);

    this.state = { message: '' };

    this.hasValue = this.hasValue.bind(this);
    this.handleClick = this.handleClick.bind(this);
  }

  hasValue(value) {
    return value && value.length > 0;
  }

  handleClick() {
    const value = this.refs.url.input.value;
    if (!this.hasValue(value)) {
      return;
    }

    const response = sendUrl(value);
    response.then((response) => {
      const { message, code } = response;

      if (code) {
        const shortUrl = absoluteUrl() + code;
        this.setState({ message: shortUrl });
        return;
      }

      if (message) {
        this.setState({ message: message });
      }
    });
  }

  render() {
    const message = this.state.message ? this.state.message : '';
    return (
      <MuiThemeProvider muiTheme={lightMuiTheme}>
        <Paper zDepth={1}>
          <TextField
            ref='url'
            hintText='Your URL here'
            underlineShow={false}
            fullWidth={true}
            style={style}
          />
          <Divider />
          <RaisedButton
            label='SHORTEN'
            fullWidth={true}
            onClick={this.handleClick}
          />
          <Divider />
          <TextField
            name='output'
            style={style}
            underlineShow={false}
            fullWidth={true}
            value={message}
          />
        </Paper>
      </MuiThemeProvider>
    );
  }
}

export default UrlShorter;
