#!/usr/bin/env python3

import faker
import requests
import json
import random

fake = faker.Faker()

register_url = "http://localhost:8080/register"
score_url = "http://localhost:8080/score"
ids = []

for i in range(1, 100):
    em = fake.email()
    response = requests.post(register_url, {"name": em})
    result = response.text.partition('\n')[0]
    ids.append(json.loads(result)['id'])
    for j in range(1, len(ids)-1):
        response = requests.post(score_url,
                                 {
                                     "id": ids[random.randint(1, len(ids)-1)],
                                     "score": random.randint(1, 100)
                                 })
        result = response.text.partition('\n')[0]
        print(result)
