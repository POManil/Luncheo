import { createBrowserRouter, Navigate } from "react-router-dom";

import Introduction from "../Introduction/Introduction";
import OrderList from "../Orders/OrderList";

const router = createBrowserRouter([
  {
    path: '/*',
    element: <OrderList />
  },
  {
    path: '/intro',
    element: <Introduction />
  },
  {
    path: '*',
    element: <Navigate to="/welcome" replace />
  }
]);

export default router;