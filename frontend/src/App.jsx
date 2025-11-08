import { Routes, Route } from 'react-router-dom';
import { CssBaseline, Container } from '@mui/material';

// PAGES 
import DetailPage from './pages/DetailPage.jsx';
import SearchPage from './pages/SearchPage.jsx';

function App() {
  return (
    <>
      <CssBaseline />
      
      <Container sx={{ py: 4 }}> 
        <Routes>
          <Route path="/" element={<SearchPage />} />
          <Route path="/cocktail/:id" element={<DetailPage />} />
        </Routes>
      </Container>
    </>
  );
}

export default App;