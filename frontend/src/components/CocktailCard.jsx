import React from 'react';
import { 
  Card, 
  CardContent, 
  CardMedia, 
  Typography, 
  CardActionArea 
} from '@mui/material';
import { useNavigate } from 'react-router-dom'; 

function CocktailCard({ drink }) {
  const navigate = useNavigate();

  const handleClick = () => {
    navigate(`/cocktail/${drink.idDrink}`);
  };

  return (
    <Card sx={{ height: '100%', display: 'flex', flexDirection: 'column' }}>
      <CardActionArea onClick={handleClick} sx={{ flexGrow: 1 }}>
        <CardMedia
          component="img"
          height="250"
          image={drink.strDrinkThumb} 
          alt={drink.strDrink}
          sx={{ objectFit: 'cover' }} 
        />
        <CardContent>
          <Typography gutterBottom variant="h5" component="div">
            {drink.strDrink} 
          </Typography>
          <Typography variant="body2" color="text.secondary">
            {drink.strTags || drink.strAlcoholic}
          </Typography>
        </CardContent>
      </CardActionArea>
    </Card>
  );
}

export default CocktailCard;