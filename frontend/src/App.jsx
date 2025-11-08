import { Routes, Route } from 'react-router-dom';
import { CssBaseline, Container } from '@mui/material';

// PAGES 
import SearchPage from './pages/SearchPage.jsx';

function App() {
  return (
    <>
      <CssBaseline />
      
      <Container sx={{ py: 4 }}> 
        <Routes>
          <Route path="/" element={<SearchPage />} />
        </Routes>
      </Container>
    </>
  );
}

export default App;