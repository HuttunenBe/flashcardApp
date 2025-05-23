import { useState } from "react";
import axios from "axios";
import "../../css/styles.css";

function Flashcard({ word, onFavoriteToggled }) {
    const [flipped, setFlipped] = useState(false);

    const handleToggleFavorite = async (e) => {
        try {
            const response = await axios.post(`/api/words/${word.id}/favorite`);
            if (onFavoriteToggled) {
                onFavoriteToggled(response.data);
            }
        } catch (error) {
            console.error("Failed to save favorite", error);
        }
    };

    return (
        <div
            className="flashcard"
            onClick={() => setFlipped(!flipped)}

        >
            {flipped ? (
                <div>
                    <h2 className>{word.finnish}</h2>
                    <h2 className>{word.english}</h2>
                    <h3>{word.example}</h3>
                    <button
                        onClick={handleToggleFavorite}
                        className="favoriteButton"
                    >
                        Favorite
                    </button>
                </div>
            ) : (
                <div>
                    <h2>{word.finnish}</h2>
                </div>
            )}
        </div>
    );
}

export default Flashcard;
