import numpy as np
from tensorflow.keras.models import load_model
from tensorflow.keras.preprocessing import image
from flask import Flask, request, jsonify
import os

app = Flask(__name__)
model = load_model("xray_cnn_model.h5")
class_names = ['Lung_Opacity', 'Normal', 'Pneumonia']

@app.route('/predict', methods=['POST'])
def predict():
    if 'file' not in request.files:
        return jsonify({'error': 'No file provided'}), 400

    file = request.files['file']
    img_path = "temp_image.jpg"
    file.save(img_path)

    # Préparation de l'image
    img = image.load_img(img_path, target_size=(64, 64))
    img_array = image.img_to_array(img) / 255.0
    img_array = np.expand_dims(img_array, axis=0)

    # Prédiction
    predictions = model.predict(img_array)[0]
    predicted_index = np.argmax(predictions)
    predicted_label = class_names[predicted_index]
    confidence = float(predictions[predicted_index])

    os.remove(img_path)

    return jsonify({'label': predicted_label, 'confidence': confidence})

if __name__ == '__main__':
    app.run(debug=True, port=5000)
