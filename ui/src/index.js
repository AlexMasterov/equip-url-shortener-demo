import React from 'react';
import { render } from 'react-dom';
import Root from './containers/Root';

import './styles';

const rootElement = document.getElementById('root');
render(
  <Root />,
  rootElement
);
