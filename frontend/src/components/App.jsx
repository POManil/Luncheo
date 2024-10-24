import './App.less';

import { RouterProvider } from 'react-router-dom';
import router from './Navigation/router';

import { AxiosProvider } from '../API/config/AxiosProvider';

import { QueryClientProvider } from '@tanstack/react-query';
import { queryClient } from '../API/config/queryClient';

function App() {
  return <>
    <AxiosProvider>
      <QueryClientProvider client={queryClient}>
        <RouterProvider router={router}/>
      </QueryClientProvider>
    </AxiosProvider> 
  </>;
}

export default App
